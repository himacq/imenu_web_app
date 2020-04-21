<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ClassificationCollection;
use App\Http\Resources\RestaurantReviewsCollection;
use App\Models\Classification;
use App\Models\Restaurant;
use App\Models\Lookup;
use App\Models\RegistrationsQuestion;
use App\Models\RestaurantClassification;
use App\Models\RestaurantRegistration;
use App\Models\RegistrationsQuestionsAnswer;

use App\Http\Resources\Restaurant as RestaurantResource;
use App\Http\Resources\RestaurantCollection ;
use App\Http\Resources\RegistrationsQuestionCollection ;
use App\Http\Resources\RestaurantClassificationCollection;
use App\Http\Resources\CategoryCollection;
use App\Models\RestaurantReview;
use Illuminate\Http\Request;
use App\Http\Resources\LookupCollection;
use DB;
use App\Helpers\General\CollectionHelper;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \App\Http\Controllers\type
     */
    public function review(Request $request){
        $rules = [
            'review_text' => 'required|min:3',
            'review_rank' => 'required|integer',
            'restaurant_id'=>'required'
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }

        $restaurant = Restaurant::find($request->restaurant_id);
        if(!$restaurant)
            return $this->response(null, false,__('api.not_found'));


        $review = RestaurantReview::create([
            'review_text' => $request->review_text,
            'review_rank' => $request->review_rank,
            'isActive' => 1,
            'user_id' => $this->user->id,
            'restaurant_id'=>$restaurant->id
        ]);


        $reviewsCollection =  new RestaurantReviewsCollection($restaurant->reviews->where('isActive',1));
        return $reviewsCollection->additional(['status'=>true,'message'=>__('api.success')]);
    }

    /**
     * categories of restaurants
     */
    public function restaurant_categories(){
        $classifications = new  ClassificationCollection(Classification::where(['isActive'=>1])->get());
        return $classifications->additional(['status'=>true,'message'=>__('api.success')]);

    }
    /**
     * restaurants api services
     */

    public function withinMaxDistance(Request $request) {

        $restaurants = Restaurant::selectRaw('*, ( 111.045 * acos( cos( radians( ? ) ) * cos( radians( latitude ) )'
                . ' * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) )'
                . ' * sin( radians( latitude ) ) ) ) AS distance'
                , [$request->latitude, $request->longitude, $request->latitude])
                    ->having('distance', '<', $request->distance)
                    ->orderBy('distance')
                    ->get();

    return $restaurants;
    }

    /**
     * @param Request $request
     * @return RestaurantCollection
     */
    public function listRestaurants_try(Request $request){


        $order = ($request->order?$request->order:"ASC");
        $sort = ($request->sort?$request->sort:"name");

        $filter = ['isActive'=>1];

        $restaurants = Restaurant::where($filter);

        if($request->name)
            $restaurants->where('name','like','%'.$request->name.'%');

        if($request->classification)
            $restaurants->whereHas('classifications', function ($query) use ($request) {
                $query->whereIn('classification_id', $request->classification);
            });

        if($request->category)
            $restaurants->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('id', $request->category);
            });


        $restaurants = $restaurants->get();
        //calculate distance and duration
        $restaurants->each(function($restaurant) use($request) {
            $result = $this->calculate_distance_time($restaurant->latitude,$restaurant->longitude,$request->latitude,$request->longitude);
            $restaurant->duration_value = $result['duration']->value;
        });


        $newCollection = $restaurants->sortByDesc('duration_value')->all();
        dd(collect(array_values($newCollection)));

        $newCollectionPaginated =  CollectionHelper::paginate($newCollection, count($restaurants), \Config::get('settings.per_page'));

        return $newCollectionPaginated;
        $restaurants = $restaurants->paginate(\Config::get('settings.per_page'));


        $restaurants = new RestaurantCollection($restaurants,$request->latitude, $request->longitude);
        return $restaurants->additional(['status'=>true,'message'=>__('api.success')]);
    }

    private function calculate_distance_time($lat1,$long1,$lat2,$long2){
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$lat1,$long1"
            ."&destination=$lat2,$long2&key=".\Config::get('settings.google_map_key');
        $request = json_decode(file_get_contents($url));

        $result['distance'] = $request->routes[0]->legs[0]->distance;
        $result['duration'] = $request->routes[0]->legs[0]->duration;

        return $result;
    }


    public function listRestaurants(Request $request){


        $order = ($request->order?$request->order:"asc");
        $sort = ($request->sort?$request->sort:"name");

        $filter = ['isActive'=>1];

        $restaurants = Restaurant::where($filter);

        if($request->name)
            $restaurants->where('name','like','%'.$request->name.'%');

        if($request->classification)
            $restaurants->whereHas('classifications', function ($query) use ($request) {
                $query->whereIn('classification_id', $request->classification);
            });

        if($request->category)
            $restaurants->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('id', $request->category);
            });



        $restaurants = $restaurants->get();
        ///
        /// Transform
        ///
        $dataCollection = $restaurants->transform(function ($data) use ($request) {
            $ranks = 0;
            if($data->reviews){
                if($data->reviews->count())
                    $ranks = number_format($data->reviews->sum('review_rank')/$data->reviews->count(),2);
            }

            $result_distance_time = $this->calculate_distance_time($request->latitude,$request->longitude,$data->latitude ,$data->longitude);

            return [
                'id' => $data->id,
                'name' => $data->translate('name'),
                'logo' => url('/uploads/restaurants/logos/'.($data->logo?$data->logo:'default.png')),
                'banner' => url('/uploads/restaurants/banners/'.($data->banner?$data->banner:'default.jpg')),
                'classification' =>new RestaurantClassificationCollection($data->classifications),
                'categories'=> new CategoryCollection($data->categories->where('isActive',1)),
                'owner_id' => $data->owner_id,
                'owner_name' => ($data->owner?$data->owner->name:null),
                'latitude' => $data->latitude,
                'longitude' => $data->longitude,
                'extra_info' => $data->translate('extra_info'),
                'phone1' => $data->phone1,
                'phone2' => $data->phone2,
                'phone3' => $data->phone3,
                'mobile1' => $data->mobile1,
                'mobile2' => $data->mobile2,
                'email' => $data->email,
                'branch_of' => $data->branch_of,
                'branch_of_name' => ($data->main_branch?$data->main_branch->translate('name'):null),
                'created_at'=>date('d-m-Y', strtotime($data->created_at)),
                'reviews_count'=>$data->reviews->count(),
                'rank' => $ranks,
                'allowed_distance'=> number_format($data->distance,2),
                'distance_text'=>$result_distance_time['distance']->text,
                'distance'=>$result_distance_time['distance']->value,
                'duration_text'=>$result_distance_time['duration']->text,
                'duration'=>$result_distance_time['duration']->value
            ];
        });


        if($order=="asc")
            $newCollection = $dataCollection->sortBy($sort);
        else
            $newCollection = $dataCollection->sortByDesc($sort);

        $newCollection = $newCollection->values();

        $newCollectionPaginated =  CollectionHelper::paginate($newCollection, count($dataCollection), \Config::get('settings.per_page'));;


        $all_data =  $newCollectionPaginated->toArray();
        $data = $all_data['data'];
        $links = [
            'first'=>$all_data['first_page_url'],
            'last'=>$all_data['last_page_url'],
            'prev'=>$all_data['prev_page_url'],
            'next'=>$all_data['next_page_url']
        ];

        $meta = [
            "current_page"=>$all_data['current_page'],
            "from"=>$all_data['from'],
            "last_page"=>$all_data['last_page'],
            "path"=>$all_data['path'],
            "per_page"=>$all_data['per_page'],
            "to"=>$all_data['to'],
            "total"=>$all_data['total']
        ];

        return [
            "data"=>$data,
            "links"=>$links,
            "meta"=>$meta,
            'status'=>true,
            'message'=>__('api.success')
        ];
    }


    /**
     * get restaurant details
     */
    public function Restaurant($id){
        $restaurant = Restaurant::where(['id'=>$id,'isActive'=>1])->first();

        if(!$restaurant)
            return $this->response(null, false,__('api.not_found'));

        $restaurant->isFavourite = 0;
        if($this->user){

            $fav = $this->user->getFavouriteRestaurants()->where(['restaurant_id'=>$restaurant->id])->first();
            if($fav)
                $restaurant->isFavourite = 1;
        }


            $restaurant = new RestaurantResource($restaurant);
            return $restaurant->additional(['status'=>true,'message'=>__('api.success')]);


    }


    /**
     * get registration questions
     */
    public function listQuestions(){
            $questions = new RegistrationsQuestionCollection(RegistrationsQuestion::all());
        return $questions->additional(['status'=>true,'message'=>__('api.success')]);

    }

    /**
     * register a restaurant
     */

    public function register(Request $request){
        $rules = [
            'name' => 'required|max:255',
            'id_img' => 'required',
            'license_img' => 'required',
            'education_level' => 'required',
            'city' => 'required',
            'locality' => 'required',
            'address' => 'required',
            'duty' => 'required',
            'starting' => 'required',
            'ending' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'distance' => 'required',
            'business_title' => 'required',
            'branches_count' => 'required',
        ];

          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }

        $id_img = $this->storeImage($request->id_img,'/uploads/restaurants/ids/',$request->name);
        $license_img = $this->storeImage($request->license_img,'/uploads/restaurants/license/',$request->name);

        $restaurant = RestaurantRegistration::create([
            'user_id' => $this->user->id,
            'name' => $request->name,
            'id_img' => $id_img,
            'license_img' => $license_img,
            'education_level' => $request->education_level,
            'city' => $request->city,
            'locality' => $request->locality,
            'address' => $request->address,
            'duty' => $request->duty,
            'starting' => $request->starting,
            'ending' => $request->ending,
            'email' => $request->email,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'distance' => $request->distance,
            'business_title' => $request->business_title,
            'branches_count' => $request->branches_count,
            'branches' => json_encode($request->branches),
            'status'=>\Config::get('settings.restaurant_review_status')
        ]);

        if(is_array($request->general_questions)){
                foreach($request->general_questions as $answers){
                    foreach($answers as $key=>$value){
                        RegistrationsQuestionsAnswer::create([
                        "registration_id"=>$restaurant->id,
                        "question_id"=>$key,
                        "answer"=>$value
                    ]);
                    }
                }
        }

        return $this->response($restaurant->toArray(), true,__('api.success'));
    }

}

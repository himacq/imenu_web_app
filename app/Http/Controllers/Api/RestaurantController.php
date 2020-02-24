<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Restaurant;
use App\Models\Lookup;
use App\Models\RegistrationsQuestion;
use App\Models\RestaurantRegistration;
use App\Models\RegistrationsQuestionsAnswer;

use App\Http\Resources\Restaurant as RestaurantResource;
use App\Http\Resources\RestaurantCollection ;
use App\Http\Resources\RegistrationsQuestionCollection ;
use Illuminate\Http\Request;
use App\Http\Resources\LookupCollection;
use DB;

use Illuminate\Support\Facades\Validator;

class RestaurantController extends ApiController
{  
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * categories of restaurants
     */
    public function restaurant_categories(){
            $categories = new LookupCollection(Lookup::where(['parent_id' =>\Config::get('settings.restaurant_categories')])->get());
        return $categories->additional(['status'=>true,'message'=>__('api.success')]);

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

    public function listRestaurants(Request $request){
       $order = ($request->order?$request->order:"ASC");
       
        if($request->latitude && $request->longitude){
             $restaurants = Restaurant::selectRaw('*, ( 111.045 * acos( cos( radians( ? ) ) * cos( radians( latitude ) )'
                . ' * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) )'
                . ' * sin( radians( latitude ) ) ) ) AS distance '
                , [$request->latitude, $request->longitude, $request->latitude])
                    ->having('distance', '<', $request->distance)
                    ->having('isActive','=',1);
                    //->paginate(\Config::get('settings.per_page'))
           if($request->category)
                $restaurants = $restaurants->having('category','=',$request->category);
           
          
           if($request->sort)
                    $restaurants = $restaurants->orderBy($request->sort,$order);
           
               $restaurants = $restaurants->simplePaginate(\Config::get('settings.per_page'));//(\Config::get('settings.per_page'));
        }
        else{
            $filter = ['isActive'=>1];
       
            if($request->category)
               $filter['category'] =$request->category;

               $restaurants = Restaurant::where($filter);
               if($request->sort)
                    $restaurants = $restaurants->orderBy($request->sort,$order);
               
               $restaurants = $restaurants->paginate(\Config::get('settings.per_page'));
        }
        $restaurants = new RestaurantCollection($restaurants);

         
        return $restaurants->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    
    
    /**
     * get restaurant details
     */
    public function Restaurant($id){
        $restaurant = Restaurant::where(['id'=>$id,'isActive'=>1])->first();
        if(!$restaurant)
            return $this->response(null, false,__('api.not_found'));
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

<?php

namespace App\Http\Controllers;

use App\Models\AdminRestaurantReview;
use App\Models\AppReview;
use App\Models\Classification;
use App\Models\PaymentMethod;
use App\Models\RestaurantClassification;
use App\Models\RestaurantPaymentMethod;
use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\GMaps;

use App\Models\Lookup;
use App\Models\Restaurant;
use App\Models\RestaurantRegistration;
use App\Models\RestaurantReview;
use App\Models\User;


use DataTables;
use phpDocumentor\Reflection\Types\Null_;

class RestaurantController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin|a|superadmin||e']);

        $this->change_language();
        $this->data['menu'] = 'restaurant';
        $this->data['selected'] = 'restaurants';
        $this->data['location'] = 'restaurants';
        $this->data['location_title'] = trans('main.restaurants');


    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registeredRestaurants()
    {
        $this->data['sub_menu'] = 'register-restaurants';
        $this->data['restaurant_status'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.restaurant_status')])->get();
        return view('restaurant.registered', $this->data);
    }
    public function registeredContentListData(Request $request)
    {
        if ($request->status)
            $restaurants = RestaurantRegistration::where('status', '=', $request->status)->get();

        else
            $restaurants = RestaurantRegistration::all();

        return DataTables::of($restaurants)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('status', function ($model) {
                return $model->status_text->translate('display_text');
            })

            ->EditColumn('owner', function ($model) {
                if($model->owner)
                    return $model->owner->name;
                else return trans('main.undefined');
            })

            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })->addColumn('control', function ($model) {
                $id = $model->id;
                return "<a class='btn dark btn-sm btn-outline sbold uppercase' "
                . " href = '" . url("registered-restaurant/" . $id . "") . "'>"
                        . "<i class='fa fa-share' ></i >"
                        . trans('main.view')
                        . "</a>";

            })
            ->rawColumns(['control'])
            ->make(true);

    }

    public function registeredRestaurantView($id)
    {
        $this->data['sub_menu'] = 'register-restaurants';
        $this->data['restaurant'] = RestaurantRegistration::find($id);
        $this->data['status'] = Lookup::where(['parent_id'=>\Config::get('settings.restaurant_status')])->get();
        $this->data['branches'] = json_decode($this->data['restaurant']->branches);

        /*********************/
        // google map generation
        if($this->data['restaurant']->latitude && $this->data['restaurant']->longitude){
            $this->data['center_lat'] = $this->data['restaurant']->latitude;
            $this->data['center_long'] = $this->data['restaurant']->longitude;

            $this->data['marker_lat'] = $this->data['restaurant']->latitude;
            $this->data['marker_long'] = $this->data['restaurant']->longitude;
            $this->data['zoom'] = 15;
        }
        else {
            $this->data['center_lat'] = "38.9637";
            $this->data['center_long'] = "35.2433";
            $this->data['marker_lat'] = "38.9637";
            $this->data['marker_long'] = "35.2433";
            $this->data['zoom'] = 5;
        }

        return view('restaurant.registeredView', $this->data);
    }

        public function registeredRestaurantStatus(Request $request,$id)
    {

         $restaurant_registered = RestaurantRegistration::find($id);
         $status = $request->status;

             $restaurant_registered->update([
                    'status' => $status,
                ]);
             if($status==\Config::get('settings.restaurant_reject_status')){
                 return redirect()->route('restaurant.registered')->with('status', trans('main.success'));
             }


             // move the restaurant to restaurants table
             $restaurant = Restaurant::create([
                 'email' => $restaurant_registered->email,
                 'phone1'=>$restaurant_registered->phone,
                 'owner_id'=>$restaurant_registered->user_id,
                 'verification_code'=>str_random(4),
                 'isActive'=>0,
                 'name'=>$restaurant_registered->name,
                 'commision'=>$request->commision,
                 'discount'=>$request->discount,
                 'distance'=>$request->distance,
                 'latitude'=>$request->latitude,
                 'longitude'=>$request->longitude
             ]);

             if($restaurant){
                 $user = User::find($restaurant_registered->user_id);
                 $user->update(['restaurant_id'=>$restaurant->id]);
                 $user->roles()->detach();
                 $user->attachRole(2);
                 $branches = json_decode($restaurant_registered->branches);
                 foreach($branches as $branch){
                     $newrestaurant = Restaurant::create([
                    'email' => $restaurant_registered->email,
                    'phone1'=>$restaurant_registered->phone,
                    'owner_id'=>null,
                    'verification_code'=>str_random(4),
                    'isActive'=>0,
                    'name'=>$branch->name,
                    'branch_of'=>$restaurant->id
                ]);
                 }
             }




        return redirect()->route('restaurant.registered')->with('status', trans('main.success'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->user->hasRole('admin'))
            return redirect()->route('home');
        $this->data['sub_menu'] = 'Display-restaurants';

        return view('restaurant.index', $this->data);
    }

    public function activeRestaurant(Request $request)
    {
        $restaurant_id = $request->id;
        $isActive = $request->active;

        $restaurant = Restaurant::find($restaurant_id);
        $restaurant->update([
            'isActive' => $isActive,
        ]);

        if($isActive){
            $owner = $restaurant->owner;
            $owner->roles()->detach();
            $owner->attachRole(2);

        }

    }

    public function contentListData(Request $request)
    {
        if ($request->status) {
            if($request->status==-1)$request->status=0;
            $restaurants = Restaurant::where(['isActive'=>$request->status,'branch_of'=>null])->get();

        }else
            $restaurants = Restaurant::where(['branch_of'=>null])->get();

        return DataTables::of($restaurants)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->addColumn('active', function ($model) {


                $activeON = "";
                $activeOff = "";
                $model->isActive !=0 ? $activeON = "active" : $activeOff = "active";
                return '<div class="btn-group btnToggle" data-toggle="buttons" style="position: relative;margin:5px;">
                              <input type="hidden" class="id_hidden" value="' . $model->id . '">
                              <label class="btn btn-default btn-on-1 btn-xs ' . "$activeON" . '">
                              <input   type="radio" value="1" name="multifeatured_module[module_id][status]" >ON</label>
                              <label class="btn btn-default btn-off-1 btn-xs ' . "$activeOff" . '">
                              <input  type="radio" value="0" name="multifeatured_module[module_id][status]">OFF</label>
                           </div>';


            })



            ->EditColumn('owner', function ($model) {
               if($model->owner)
                   return $model->owner->name;
            })

            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })->addColumn('control', function ($model) {
                $id = $model->id;
                return "<a class='btn btn-primary btn-sm' href = '" . url("restaurants/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ".
                    "<a class='btn btn-primary btn-sm' target='_blank'  href = '" . url("acting_as/" . $id . "") . "'>".__('restaurants.restaurant_cpanel')."</a> ";

            })
            ->rawColumns(['control','active'])
            ->make(true);

    }

    public function childContentListData(Request $request)
    {

            $restaurants = Restaurant::where(['branch_of'=>$request->id])->get();

        return DataTables::of($restaurants)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
             ->EditColumn('owner', function ($model) {
                if($model->owner)
                 return $model->owner->name;

                return trans('main.undefined');
            })
            ->addColumn('active', function ($model) {


                $activeON = "";
                $activeOff = "";
                $model->isActive !=0 ? $activeON = "active" : $activeOff = "active";
                return '<div class="btn-group btnToggle" data-toggle="buttons" style="position: relative;margin:5px;">
                              <input type="hidden" class="id_hidden" value="' . $model->id . '">
                              <label class="btn btn-default btn-on-1 btn-xs ' . "$activeON" . '">
                              <input   type="radio" value="1" name="multifeatured_module[module_id][status]" >ON</label>
                              <label class="btn btn-default btn-off-1 btn-xs ' . "$activeOff" . '">
                              <input  type="radio" value="0" name="multifeatured_module[module_id][status]">OFF</label>
                           </div>';


            })


            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })->addColumn('control', function ($model) {
                $id = $model->id;
                if($this->user->hasRole('superadmin'))
                    return "<a class='btn btn-primary btn-sm' target='_blank' href = '" . url("restaurants/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ";
            else{
                return "<a class='btn btn-primary btn-sm' target='_blank' href = '" . url("restaurants/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ".
                        "<a class='btn btn-primary btn-sm' target='_blank'  href = '" . url("acting_as/" . $id . "") . "'>".__('restaurants.restaurant_cpanel')."</a> ";
            }

            })
            ->rawColumns(['control','active'])
            ->make(true);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reviewsContentListData(Request $request)
    {

        $restaurant_reviews = RestaurantReview::where(['restaurant_id'=>$request->id])->get();

        return DataTables::of($restaurant_reviews)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })


            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })
            ->make(true);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_review(Request $request,$id){

        $review = AdminRestaurantReview::create([
            'user_id'=>$this->user->id,
            'restaurant_id'=>$id,
            'review_text'=>$request->review_text,
            'review_rank'=>$request->review_rank,
            'isActive'=>1
        ]);


        return redirect()->route('restaurants.edit',$id)->with('status', trans('main.success'));

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function adminReviewsContentListData(Request $request)
    {

        $restaurant_reviews = AdminRestaurantReview::where(['restaurant_id'=>$request->id])->get();

        return DataTables::of($restaurant_reviews)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })


            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })
            ->make(true);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['users'] = User::where(['isActive'=>1,'restaurant_id'=>Null])
            ->whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
            })->get();
        $this->data['restaurant_classifications_lookup'] = Classification::where(['isActive'=>1])->get();

        $this->data['working_days'] = Lookup::where(
            ['parent_id'=>\Config::get('settings.working_days')])->get();

        $this->data['payment_methods'] = PaymentMethod::where(['isActive'=>1])->get();

        /*********************/
        // google map generation
            $this->data['center_lat'] = "38.9637";
            $this->data['center_long'] = "35.2433";
            $this->data['marker_lat'] = "38.9637";
            $this->data['marker_long'] = "35.2433";
            $this->data['zoom'] = 5;

        return view('restaurant.create', $this->data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $restaurant = Restaurant::create([
            'name' => $request->name,
            'extra_info'=>$request->extra_info,
            'phone1'=>$request->phone1,
            'phone2'=>$request->phone2,
            'phone3'=>$request->phone3,
            'mobile1'=>$request->mobile1,
            'mobile2'=>$request->mobile2,
            'email'=>$request->email,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'discount'=>$request->discount,
            'commision'=>$request->commision,
            'distance'=>$request->distance,
            'isActive'=>1
        ]);

        if($request->classification){
            for($i=0; $i<count($request->classification); $i++){
                RestaurantClassification::Create([
                    'restaurant_id' => $restaurant->id,
                    'classification_id'=>$request->classification[$i],
                ]);
            }
        }


        if($request->owner_id){
            $restaurant->update(['owner_id'=>$request->owner_id]);
            $new_manager = User::find($request->owner_id);
            $new_manager->update(['restaurant_id'=>$restaurant->id]);
            $new_manager->roles()->detach();
            $new_manager->attachRole(2);
        }


        if($request->logo){
            $file = $request->file('logo');
            $filename = "logo-".$restaurant->id.".".$file->getClientOriginalExtension();

            //Move Uploaded File
            $destinationPath = 'uploads/restaurants/logos/';
            $file->move($destinationPath,$filename);

            $restaurant->update([
                'logo' => $filename
            ]);

        }

        if($request->banner){
            $file = $request->file('banner');
            $filename = "banner-".$restaurant->id.".".$file->getClientOriginalExtension();

            //Move Uploaded File
            $destinationPath = 'uploads/restaurants/banners/';
            $file->move($destinationPath,$filename);

            $restaurant->update([
                'banner' => $filename
            ]);

        }

        if($request->day_select){
            for($i=0; $i<count($request->day_select); $i++){
                \App\Models\RestaurantWorkingDetails::updateOrCreate([
                    'restaurant_id' => $restaurant->id,
                    'working_day'=>$request->day_select[$i],
                    'start_at' =>$request->start[$i],
                    'end_at' =>$request->end[$i]
                ]);
            }
        }

        if($request->branch_name) {
            for($i=0; $i<count($request->branch_name); $i++){
                $newrestaurant = Restaurant::create([
                    'isActive' => 1,
                    'name' => $request->branch_name[$i],
                    'branch_of' => $restaurant->id
                ]);

                if($request->branch_owner_id[$i]){
                    $newrestaurant->update(['owner_id'=>$request->branch_owner_id[$i]]);
                }
            }
        }

        if($request->payment_methods){
            for($i=0; $i<count($request->payment_methods); $i++){
                RestaurantPaymentMethod::Create([
                    'restaurant_id' => $restaurant->id,
                    'payment_id'=>$request->payment_methods[$i],
                ]);
            }
        }


        return redirect()->route('restaurants.edit',$restaurant->id)->with('status', trans('main.success'));
    }

    public function reviews(){

        return view('restaurant.reviews',$this->data);

    }

    public function restaurantReviewsContentListData(Request $request)
    {

        $restaurants = Restaurant::where('owner_id','!=',NULL)->get();
        $users_array = array();

        foreach($restaurants as $restaurant){
            $users_array[] = $restaurant->owner_id;
        }


        $reviews = AppReview::whereIn('user_id',$users_array)->get();

        return DataTables::of($reviews)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })


            ->addColumn('restaurant', function ($model) {
                return $model->user->restaurant->name;

            })

            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })
            ->rawColumns(['restaurant'])
            ->make(true);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['sub_menu'] = 'restaurants-edit';
        $this->data['restaurant'] = Restaurant::find($id);


        if(!(($this->user->restaurant_id==$this->data['restaurant']->branch_of && $this->user->hasRole('admin'))
                || $this->user->hasRole(['a','superadmin','e'])))
            return  redirect()->route('logout');

        $this->data['users'] = $this->get_all_users_restaurant($this->user->restaurant_id);

        $this->data['restaurant_classifications_lookup'] = Classification::where(['isActive'=>1])->get();
        $this->data['working_days'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.working_days')])->get();
        $this->data['payment_methods'] = PaymentMethod::where(['isActive'=>1])->get();

        /*********************/
        // google map generation
        if($this->data['restaurant']->latitude && $this->data['restaurant']->longitude){
            $this->data['center_lat'] = $this->data['restaurant']->latitude;
            $this->data['center_long'] = $this->data['restaurant']->longitude;

            $this->data['marker_lat'] = $this->data['restaurant']->latitude;
            $this->data['marker_long'] = $this->data['restaurant']->longitude;
            $this->data['zoom'] = 15;
        }
        else {
            $this->data['center_lat'] = "38.9637";
            $this->data['center_long'] = "35.2433";
            $this->data['marker_lat'] = "38.9637";
            $this->data['marker_long'] = "35.2433";
            $this->data['zoom'] = 5;
        }


        $this->data['restaurant_classifications'] = $this->data['restaurant']->classifications->pluck('classification_id')->toArray();
        $this->data['restaurant_payment_methods'] = $this->data['restaurant']->payment_methods->pluck('payment_id')->toArray();

        return view('restaurant.edit', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile($branches = false)
    {

        $this->data['menu'] = 'restaurants';
        $this->data['sub_menu'] = 'restaurant_profile';
        if($branches){
            $this->data['sub_menu'] = 'branches';
        }
        $this->data['location'] = 'restaurants/profile';
        $this->data['location_title'] = trans('restaurants.restaurant_profile');

        $this->data['restaurant'] = Restaurant::find($this->user->restaurant_id);


        $this->data['payment_methods'] = PaymentMethod::where(['isActive'=>1])->get();

        $this->data['restaurant_classifications_lookup'] = Classification::where(['isActive'=>1])->get();

        $this->data['working_days'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.working_days')])->get();

        $this->data['users'] = User::where(['isActive'=>1,'restaurant_id'=>Null])
            ->whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
            })->get();
       /*********************/
        // google map generation
        if($this->data['restaurant']->latitude && $this->data['restaurant']->longitude){
            $this->data['center_lat'] = $this->data['restaurant']->latitude;
            $this->data['center_long'] = $this->data['restaurant']->longitude;

            $this->data['marker_lat'] = $this->data['restaurant']->latitude;
            $this->data['marker_long'] = $this->data['restaurant']->longitude;
            $this->data['zoom'] = 15;
        }
        else {
            $this->data['center_lat'] = "38.9637";
            $this->data['center_long'] = "35.2433";
            $this->data['marker_lat'] = "38.9637";
            $this->data['marker_long'] = "35.2433";
            $this->data['zoom'] = 5;
        }

        $this->data['restaurant_classifications'] = $this->data['restaurant']->classifications->pluck('classification_id')->toArray();
        $this->data['restaurant_payment_methods'] = $this->data['restaurant']->payment_methods->pluck('payment_id')->toArray();
        return view('restaurant.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);

        $restaurant->update([
                 'name' => $request->name,
                 'extra_info'=>$request->extra_info,
                 'phone1'=>$request->phone1,
                 'phone2'=>$request->phone2,
                 'phone3'=>$request->phone3,
                 'mobile1'=>$request->mobile1,
                 'mobile2'=>$request->mobile2,
                 'email'=>$request->email,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
             ]);

        if($this->user->hasRole(['a','superadmin','e'])){
          $restaurant->update([
                 'discount'=>$request->discount,
              'commision'=>$request->commision,
              'distance'=>$request->distance
             ]);
        }

        if($request->owner_id){
            $restaurant->update(['owner_id'=>$request->owner_id]);
            $new_manager = User::find($request->owner_id);
            $new_manager->update(['restaurant_id'=>$restaurant->id]);
            $new_manager->roles()->detach();
            $new_manager->attachRole(2);
        }

        if($request->logo){
             $file = $request->file('logo');
             $filename = "logo-".$restaurant->id.".".$file->getClientOriginalExtension();

                //Move Uploaded File
                $destinationPath = 'uploads/restaurants/logos/';
                $file->move($destinationPath,$filename);

                $restaurant->update([
                 'logo' => $filename
             ]);

        }

        if($request->banner){
             $file = $request->file('banner');
             $filename = "banner-".$restaurant->id.".".$file->getClientOriginalExtension();

                //Move Uploaded File
                $destinationPath = 'uploads/restaurants/banners/';
                $file->move($destinationPath,$filename);

                $restaurant->update([
                 'banner' => $filename
             ]);

        }

        if($request->day_select){
            for($i=0; $i<count($request->day_select); $i++){
                \App\Models\RestaurantWorkingDetails::updateOrCreate([
                    'restaurant_id' => $restaurant->id,
                    'working_day'=>$request->day_select[$i],
                    'start_at' =>$request->start[$i],
                    'end_at' =>$request->end[$i]
                ]);
            }
        }

        $restaurant->classifications()->delete();
        if($request->classification){
            for($i=0; $i<count($request->classification); $i++){
                RestaurantClassification::Create([
                    'restaurant_id' => $restaurant->id,
                    'classification_id'=>$request->classification[$i],
                ]);
            }
        }

        $restaurant->payment_methods()->delete();
        if($request->payment_methods){
            for($i=0; $i<count($request->payment_methods); $i++){
                RestaurantPaymentMethod::Create([
                    'restaurant_id' => $restaurant->id,
                    'payment_id'=>$request->payment_methods[$i],
                ]);
            }
        }


    if($this->user->hasRole('admin'))
        return back()
        ->withInput()->with('status', trans('main.success'));

        return redirect()->route('restaurants.index')->with('status', trans('main.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

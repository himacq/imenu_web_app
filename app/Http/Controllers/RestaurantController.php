<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\GMaps;

use App\Models\Lookup;
use App\Models\Restaurant;
use App\Models\RestaurantRegistration;
use App\Models\RestaurantReview;
use App\Models\User;

use DataTables;

class RestaurantController extends Controller
{
    protected $gmap;
    
    public function __construct()
    {
        $this->middleware(['role:superadmin'])->except([
            'profile',
            'childContentListData',
            'reviewsContentListData',
            'restaurant_activate',
            'edit',
            'update'
            ]);

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
                return $model->owner->name;
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
        return view('restaurant.registeredView', $this->data);
    }
    
        public function registeredRestaurantStatus(Request $request,$id)
    {
            
         $restaurant_registered = RestaurantRegistration::find($id);
         $status = $request->status;
         
             $restaurant_registered->update([
                    'status' => $status,
                ]);
             
             // move the restaurant to restaurants table
             $restaurant = Restaurant::create([
                 'email' => $restaurant_registered->email,
                 'phone1'=>$restaurant_registered->phone,
                 'owner_id'=>$restaurant_registered->user_id,
                 'verification_code'=>str_random(4),
                 'isActive'=>1,
                 'name'=>$restaurant_registered->name,
                 'commision'=>$request->commision,
                 'discount'=>$request->discount
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
                    'isActive'=>1,
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
            
            ->EditColumn('category', function ($model) {
                if($model->category)
                return $model->category_text->translate('display_text');
                else return "";
            })
            
            ->EditColumn('owner', function ($model) {
                return $model->owner->name;
            })
            
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })->addColumn('control', function ($model) {
                $id = $model->id;
                return "<a class='btn btn-primary btn-sm' href = '" . url("restaurants/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ";

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['sub_menu'] = 'restaurants-create';
        $this->data['restaurant_status'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.restaurant_status')])->get();
        return view('restaurant.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
                || $this->user->hasRole('superadmin')))
            return  redirect()->route('logout');
        
        $this->data['users'] = $this->get_all_users_restaurant($this->user->restaurant_id);
        
                   
        $this->data['restaurant_categories'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.restaurant_categories')])->get();
        $this->data['working_days'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.working_days')])->get();
        return view('restaurant.edit', $this->data);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $this->data['sub_menu'] = 'home';
        $this->data['location'] = 'restaurants/profile';
        $this->data['location_title'] = trans('restaurants.restaurant_profile');
        
        $this->data['restaurant'] = Restaurant::find($this->user->restaurant_id);

        
        $this->data['restaurant_categories'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.restaurant_categories')])->get();
        $this->data['working_days'] = Lookup::where(
                ['parent_id'=>\Config::get('settings.working_days')])->get();
        
       

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
                 'category'=>$request->category,
                 'extra_info'=>$request->extra_info,
                 'phone1'=>$request->phone1,
                 'phone2'=>$request->phone2,
                 'phone3'=>$request->phone3,
                 'mobile1'=>$request->mobile1,
                 'mobile2'=>$request->mobile2,
                 'discount'=>$request->discount,
                 'commision'=>$request->commision,
                 'email'=>$request->email
             ]);
        
        if($request->owner_id){
            $restaurant->update(['owner_id'=>$request->owner_id]);
            $new_manager = User::find($request->owner_id);
            $new_manager->update(['restaurant_id'=>$restaurant->id]);
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
           
           
           if($this->user->hasRole('admin'))
               return redirect()->route('restaurants.profile')->with('status', trans('main.success'));
             
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

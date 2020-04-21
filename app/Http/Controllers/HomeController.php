<?php

namespace App\Http\Controllers;

use App\Models\Lookup;
use App\Models\RegistrationsQuestion;
use App\Models\RegistrationsQuestionsAnswer;
use App\Models\RestaurantBilling;
use App\Models\RestaurantRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Models\AppReview;
use App\Models\RestaurantReview;

use App\Models\CustomerMessage;
use App\Models\UserMessage;
use App\Models\OrderRestaurant;
use Illuminate\Support\Facades\Session;

use DataTables;
use DateTime;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->change_language();
        $this->data['menu'] = 'home';
        $this->data['location'] = 'home';
        $this->data['location_title'] = 'home';
        $this->data['selected'] = '';


    }
    /**
     * Change the logged in user Id to act as another user and get his permissions
     * @param type $child_restaurant_id
     * @return type
     */
        public function acting_as($child_restaurant_id){
        $child_restaurant = Restaurant::find($child_restaurant_id);

        if( $this->user->hasRole(['admin','a','superadmin','e'])){
            if($this->user->hasRole('admin') && $this->user->restaurant_id!=$child_restaurant->branch_of)
                return redirect()->route('home')->withErrors([trans('main.error_acting_as')]);

            if(!$child_restaurant->owner_id)
                return redirect()->route('home')->withErrors([trans('main.error_acting_as_no_owner')]);
            session([
                'user_id' => $this->user->id,
                'acting_as'=>$child_restaurant->owner_id,
                'restaurant_name'=>$child_restaurant->translate('name')
                    ]);

            Auth::loginUsingId($child_restaurant->owner_id) ;

            return redirect()->route('home')->with('status', trans('main.restaurant_cpanel'));
        }

        return redirect()->route('home')->with('status', trans('main.success'));
    }

    public function acting_as_cancle(){

        if(session('user_id')){
            Auth::loginUsingId(session('user_id')) ;
            Session::forget('user_id');
            Session::forget('acting_as');
            return redirect()->route('home')->with('status', trans('main.success'));
        }

        return redirect()->route('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if($this->user->hasRole('superadmin')){
            $this->data['products'] = Product::where(['isActive'=>1])->get()->count();
            $this->data['restaurants'] = Restaurant::where(['branch_of'=>NULL])->get()->count();
            $this->data['orders'] = Order::all()->count();
            $this->data['customers'] = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
            })->get()->count();


            //  per month charts
            $orders_months = array();
            $payments_months = array();
            $credit_months = array();
            $debit_months = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $orders = Order::whereBetween('created_at',[$from,$to ])->get()->count();
                $payments = RestaurantBilling::whereBetween('created_at', [$from, $to])->sum('sub_total');
                $debit = RestaurantBilling::whereBetween('created_at', [$from, $to])->sum('credit');
                $credit = RestaurantBilling::whereBetween('created_at', [$from, $to])->sum('debit');


                $orders_months[$month] = $orders ;
                $payments_months[$month] = $payments ;
                $credit_months[$month] = $credit ;
                $debit_months[$month] = $debit ;
            }
            $this->data['orders_per_month'] = array_reverse($orders_months);
            $this->data['payments_per_month'] = array_reverse($payments_months);
            $this->data['credit_per_month'] = array_reverse($credit_months);
            $this->data['debit_per_month'] = array_reverse($debit_months);

            $this->data['customer_reviews'] = AppReview::orderby('id','desc')->take(4)->get();

            $this->data['restaurant_reviews'] = RestaurantReview::orderby('id','desc')->take(4)->get();

            return view('home.super_admin', $this->data);
        }

        if($this->user->hasRole('admin')){
            $this->data['products'] = Product::whereHas('category', function ($query)  {
                $query->where('restaurant_id','=', $this->user->restaurant_id);
            })->get()->count();
            $this->data['orders'] = OrderRestaurant::where(['restaurant_id'=>$this->user->restaurant_id])->get()->count();
            $this->data['payments'] = RestaurantBilling::where(['restaurant_id'=>$this->user->restaurant_id])->sum('sub_total');


            //  per month charts
            $orders_months = array();
            $payments_months = array();
            $credit_months = array();
            $debit_months = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $orders = OrderRestaurant::where(['restaurant_id'=>$this->user->restaurant_id])
                    ->whereBetween('created_at',[$from,$to ])->get()->count();
                $payments =  RestaurantBilling::where(['restaurant_id'=>$this->user->restaurant_id])
                    ->whereBetween('created_at', [$from, $to])->sum('sub_total');
                $credit = RestaurantBilling::where(['restaurant_id'=>$this->user->restaurant_id])
                    ->whereBetween('created_at', [$from, $to])->sum('credit');
                $debit= RestaurantBilling::where(['restaurant_id'=>$this->user->restaurant_id])
                    ->whereBetween('created_at', [$from, $to])->sum('debit');


                $orders_months[$month] = $orders ;
                $payments_months[$month] = $payments ;
                $credit_months[$month] = $credit ;
                $debit_months[$month] = $debit ;
            }
            $this->data['orders_per_month'] = array_reverse($orders_months);
            $this->data['payments_per_month'] = array_reverse($payments_months);
            $this->data['credit_per_month'] = array_reverse($credit_months);
            $this->data['debit_per_month'] = array_reverse($debit_months);

            $this->data['admin_reviews'] = App\Models\AdminRestaurantReview::where(['restaurant_id'=>$this->user->restaurant_id])
                                            ->orderby('id','desc')->take(4)->get();

            $this->data['customer_reviews'] = RestaurantReview::where(['restaurant_id'=>$this->user->restaurant_id])
                                                ->orderby('id','desc')->take(4)->get();

            return view('home.admin', $this->data);
        }

        if($this->user->hasRole('d')){
            $this->data['online_payments_total'] = RestaurantBilling::where(['payment_id'=>1])->sum('sub_total');
            $this->data['cash_payments_total'] = RestaurantBilling::where(['payment_id'=>2])->sum('sub_total');

            //  per month charts
            $online_payments_months = array();
            $cash_payments_months = array();
            $credit_months = array();
            $debit_months = array();
            $bills_months = array();
            $bills_paid_months = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $online = RestaurantBilling::where(['payment_id'=>1])->whereBetween('created_at',[$from,$to ])->sum('sub_total');
                $cash = RestaurantBilling::where(['payment_id'=>2])->whereBetween('created_at', [$from, $to])->sum('sub_total');
                $debit = RestaurantBilling::whereBetween('created_at', [$from, $to])->sum('credit');
                $credit = RestaurantBilling::whereBetween('created_at', [$from, $to])->sum('debit');
                $bills = RestaurantBilling::whereBetween('created_at', [$from, $to])->get()->count();
                $bills_paid = RestaurantBilling::where(['paid'=>1])->whereBetween('paid_at', [$from, $to])->get()->count();


                $online_payments_months[$month] = $online ;
                $cash_payments_months[$month] = $cash ;
                $credit_months[$month] = $credit ;
                $debit_months[$month] = $debit ;
                $bills_months[$month] = $bills ;
                $bills_paid_months[$month] = $bills_paid ;
            }
            $this->data['online_payments_per_month'] = array_reverse($online_payments_months);
            $this->data['cash_payments_per_month'] = array_reverse($cash_payments_months);
            $this->data['credit_per_month'] = array_reverse($credit_months);
            $this->data['debit_per_month'] = array_reverse($debit_months);
            $this->data['bills_per_month'] = array_reverse($bills_months);
            $this->data['bills_paid_per_month'] = array_reverse($bills_paid_months);

            return view('home.role_d', $this->data);
        }

        if($this->user->hasRole('a')){
            $this->data['restaurants'] = Restaurant::where(['branch_of'=>NULL])->get()->count();
            $this->data['new_restaurants'] = RestaurantRegistration::where(['status'=>\Config::get('settings.restaurant_review_status')])->get()->count();
            $this->data['restaurant_reviews_count'] = RestaurantReview::all()->count();


            //  per month charts
            $restaurants_months = array();
            $reviews_months = array();

            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $restaurants = RestaurantRegistration::whereBetween('created_at', [$from, $to])->get()->count();
                $restaurant_reviews = RestaurantReview::whereBetween('created_at', [$from, $to])->get()->count();


                $restaurants_months[$month] = $restaurants ;
                $reviews_months[$month] = $restaurant_reviews ;
            }
            $this->data['restaurants_per_month'] = array_reverse($restaurants_months);
            $this->data['reviews_per_month'] = array_reverse($reviews_months);

            $this->data['restaurants_registrations'] = RestaurantRegistration::where(['status'=>\Config::get('settings.restaurant_review_status')])->orderby('id','desc')->take(4)->get();
            $this->data['restaurant_reviews'] = RestaurantReview::orderby('id','desc')->take(4)->get();

            return view('home.role_a', $this->data);
        }

        if($this->user->hasRole('e')){
            $this->data['restaurants'] = Restaurant::where(['branch_of'=>NULL])->get()->count();
            $this->data['customers_count'] = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
            })->get()->count();


            //  per month charts
            $restaurants_months = array();
            $users_months = array();

            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $restaurants = Restaurant::where(['branch_of'=>NULL])->whereBetween('created_at', [$from, $to])->get()->count();
                $users = User::whereDoesntHave('roles', function ($query) {
                    $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
                })->whereBetween('created_at', [$from, $to])->get()->count();


                $restaurants_months[$month] = $restaurants ;
                $users_months[$month] = $users ;
            }

            $this->data['restaurants_per_month'] = array_reverse($restaurants_months);
            $this->data['customers_per_month'] = array_reverse($users_months);


            return view('home.role_e', $this->data);
        }


        if($this->user->hasRole('b')){
            $this->data['customer_reviews_count'] = AppReview::all()->count();
            $this->data['orders'] = Order::all()->count();
            $this->data['customers_count'] = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
            })->get()->count();


            //  per month charts
            $orders_months = array();
            $reviews_months = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $orders = Order::whereBetween('created_at',[$from,$to ])->get()->count();
                $reviews = AppReview::whereBetween('created_at', [$from, $to])->get()->count();

                $orders_months[$month] = $orders ;
                $reviews_months[$month] = $reviews ;
            }
            $this->data['orders_per_month'] = array_reverse($orders_months);
            $this->data['reviews_per_month'] = array_reverse($reviews_months);

            $this->data['customer_reviews'] = AppReview::orderby('id','desc')->take(4)->get();

            $this->data['customers'] = User::orderby('id','desc')->whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
            })->take(8)->get();

            return view('home.role_b', $this->data);
        }

        if($this->user->hasRole('c')){
            $this->data['customer_messages_count'] = CustomerMessage::where(['message_type'=>1])->get()->count();
            $this->data['restaurant_messages_count'] = UserMessage::where(['message_type'=>1])->get()->count();

            //  per month charts
            $customer_messages_months = array();
            $restaurant_messages_months = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $customerMessages = CustomerMessage::where(['message_type'=>1])->whereBetween('created_at',[$from,$to ])->get()->count();
                $restaurantMessages = UserMessage::where(['message_type'=>1])->whereBetween('created_at', [$from, $to])->get()->count();

                $customer_messages_months[$month] = $customerMessages ;
                $restaurant_messages_months[$month] = $restaurantMessages ;
            }
            $this->data['customer_messages_months'] = array_reverse($customer_messages_months);
            $this->data['restaurant_messages_months'] = array_reverse($restaurant_messages_months);

            return view('home.role_c', $this->data);
        }

        if($this->user->hasRole('c2')){
            //  per month charts
            $customer_messages_months = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $customerMessages = CustomerMessage::where(['message_type'=>1])->whereBetween('created_at',[$from,$to ])->get()->count();

                $customer_messages_months[$month] = $customerMessages ;
            }
            $this->data['customer_messages_months'] = array_reverse($customer_messages_months);
            $this->data['customer_messages'] = CustomerMessage::where(['message_type'=>1])->orderby('id','desc')->take(5)->get();

            return view('home.role_c2', $this->data);
        }

        if($this->user->hasRole('c1')){
            //  per month charts
            $restaurant_messages_months = array();
            for ($i = 0; $i < 6; $i++) {
                $month = date('m/Y', strtotime("-$i month"));
                $from = date('Y-m-01 00:00:00',strtotime("-$i month"));
                $to = date('Y-m-t 23:59:59',strtotime("-$i month"));
                $restaurantMessages = UserMessage::where(['message_type'=>1])->whereBetween('created_at', [$from, $to])->get()->count();

                $restaurant_messages_months[$month] = $restaurantMessages ;
            }
            $this->data['restaurant_messages_months'] = array_reverse($restaurant_messages_months);
            $this->data['restaurant_messages'] = UserMessage::where(['message_type'=>1])->orderby('id','desc')->take(5)->get();

            return view('home.role_c1', $this->data);
        }

        if($this->user->restaurant_id && $this->user->restaurant->isActive == 0
            && $this->user->restaurant->branch_of==null) {
            $fdate = $this->user->restaurant->created_at;
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $interval = $datetime2->diff($datetime1);
            $hours = $interval->h;
            $this->data['hours'] = $hours + ($interval->days*24);

            if($this->data['hours']>=24)
                $this->user->roles()->detach();

                return view('restaurant.suspended', $this->data);


        }

        if(!($this->user->restaurant_id || $this->user->hasRole(['superadmin','a','b','c','c1','c2','d']))){

            if($this->user->restaurant_registration){
                $this->data['sub_menu'] = 'register-restaurants';
                $this->data['restaurant'] = $this->user->restaurant_registration;
                $this->data['status'] = Lookup::where(['parent_id'=>\Config::get('settings.restaurant_status')])->get();
                $this->data['branches'] = json_decode($this->data['restaurant']->branches);
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

                return view('restaurant.register_response', $this->data);
            }
            $this->data['questions'] = RegistrationsQuestion::all();

            /*********************/
            // google map generation
                $this->data['center_lat'] = "38.9637";
                $this->data['center_long'] = "35.2433";
                $this->data['marker_lat'] = "38.9637";
                $this->data['marker_long'] = "35.2433";
                $this->data['zoom'] = 5;


            return view('restaurant.register', $this->data);
        }

        $this->data['products'] = Product::all()->count();
        $this->data['restaurants'] = Restaurant::all()->count();
        $this->data['orders'] = Order::all()->count();
        $this->data['users'] = User::all()->count();


        return view('home', $this->data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register_restaurant(Request $request){

        if($request->id_img){
            $file = $request->file('id_img');
            $id_filename = $request->name.'.'.$file->getClientOriginalExtension();

            //Move Uploaded File
            $destinationPath = 'uploads/restaurants/ids/';
            $file->move($destinationPath,$id_filename);
        }

        if($request->license_img){
            $file = $request->file('license_img');
            $lic_filename = $request->name.'.'.$file->getClientOriginalExtension();

            //Move Uploaded File
            $destinationPath = 'uploads/restaurants/license/';
            $file->move($destinationPath,$lic_filename);
        }

        $branches = array();
        if(is_array($request->branch_name)) {
            for ($i = 0; $i < count($request->branch_name); $i++) {
                $branches[] = ['name' => $request->branch_name[$i], 'address' => $request->branch_address[$i]];
            }
        }

        $restaurant = RestaurantRegistration::create([
            'user_id' => $this->user->id,
            'name' => $request->name,
            'id_img' => $id_filename,
            'license_img' => $lic_filename,
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
            'branches_count' => count($branches),
            'branches' => json_encode($branches),
            'status'=>\Config::get('settings.restaurant_review_status')
        ]);



        if(is_array($request->question_answer)){
            for($i=1;$i<=count($request->question_answer);$i++){
                    RegistrationsQuestionsAnswer::create([
                        "registration_id"=>$restaurant->id,
                        "question_id"=>$request->question_id[$i-1],
                        "answer"=>$request->question_answer[$i][0]
                    ]);
            }
        }


        return redirect()->route('home');
    }

    /**
     *
     * @param type $language_id
     * @return type
     */
    public function changeLanguage($language_id){
        $user = Auth::user();
        unset($user->isAdmin);
        $user->update(['language_id'=>$language_id]);
        App::setLocale($language_id);

        return back();
    }

    /**
     *
     * @param Request $request
     * @param type $id
     * @return type
     */
     public function app_review(){
        $this->data['app_reviews'] = $this->user->app_reviews;

        return view('app_reviews',$this->data);

    }

    public function store_app_review(Request $request){

        $review = AppReview::create([
            'user_id'=>$this->user->id,
            'review_text'=>$request->review_text,
            'review_rank'=>$request->review_rank,
            'isActive'=>1
        ]);


        return redirect()->route('app_reviews')->with('status', trans('main.success'));

    }

    public function reviewsContentListData(Request $request)
    {

        $reviews = AppReview::where(['user_id'=>$this->user->id])->get();

        return DataTables::of($reviews)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->addColumn('status', function ($model) {
                return ($model->isActive?"Active":"Disabled");

            })

            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })
            ->rawColumns(['status'])
            ->make(true);

    }



}

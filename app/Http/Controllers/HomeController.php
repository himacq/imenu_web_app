<?php

namespace App\Http\Controllers;

use App\Models\Lookup;
use App\Models\RegistrationsQuestion;
use App\Models\RegistrationsQuestionsAnswer;
use App\Models\RestaurantRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Models\AppReview;

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

        if( $this->user->hasRole(['admin','a','superadmin'])){
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
                return view('restaurant.register_response', $this->data);
            }
            $this->data['questions'] = RegistrationsQuestion::all();
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
        for($i=0;$i<count($request->branch_name);$i++){
            $branches[] = ['name'=>$request->branch_name[$i] , 'address'=>$request->branch_address[$i]];
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

<?php

namespace App\Http\Controllers;

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
        
        if($this->user->restaurant_id==$child_restaurant->branch_of && $this->user->hasRole('admin')){
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
        $this->data['products'] = Product::all()->count();
        $this->data['restaurants'] = Restaurant::all()->count();
        $this->data['orders'] = Order::all()->count();
        $this->data['users'] = User::all()->count();
        
        return view('home', $this->data);
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

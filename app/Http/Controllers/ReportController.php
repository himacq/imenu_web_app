<?php

namespace App\Http\Controllers;

use App\Models\CustomerMessage;
use App\Models\Lookup;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderRestaurant;
use App\Models\OrderRestaurantStatus;
use App\Models\PaymentMethod;
use App\Models\ProductReview;
use App\Models\Restaurant;
use App\Models\RestaurantBilling;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->change_language();
        $this->middleware('role:admin||superadmin||b||c||d');
        $this->data['menu'] = 'reports';


    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders_org(Request $request){
        $this->data['selected'] = 'orders';
        $this->data['location'] = 'orders';
        $this->data['location_title'] = __('main.orders');
        $this->data['sub_menu'] = 'orders';

        $this->data['from'] = date('Y-m-d');
        $this->data['to'] = date('Y-m-d');

        if ($request->isMethod('post')){
            $this->data['from'] = $request->from;
            $this->data['to'] = $request->to;
        }

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        if($this->user->hasRole('superadmin'))
            $this->data['reportData'] = OrderRestaurant::whereBetween('created_at',[$from,$to ])->get();

        else
            $this->data['reportData'] = OrderRestaurant::whereBetween('created_at',[$from,$to ])
                ->where(['restaurant_id'=>$this->user->restaurant_id])->get();

        return view('report.order',$this->data);

    }

    public function orders(Request $request){
        $this->data['selected'] = 'orders';
        $this->data['location'] = 'orders';
        $this->data['location_title'] = __('main.orders');
        $this->data['sub_menu'] = 'orders';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        if($this->user->hasRole(['superadmin']))
            $this->data['restaurants'] = Restaurant::where(['branch_of'=>NULL])->get();

        $this->data['order_status'] = Lookup::where(
            ['parent_id'=>\Config::get('settings.order_status')])->get();

        return view('report.order',$this->data);

    }

    public function orders_print(Request $request){
        $this->data['from'] = $request->from;
        $this->data['to'] = $request->to;

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        if ($request->status) {
            $filter_array = [
                \Config::get('settings.new_order_status'),
                \Config::get('settings.payment_order_status'),
                \Config::get('settings.progress_order_status'),
                \Config::get('settings.complete_order_status'),
                \Config::get('settings.cancled_order_status'),
                \Config::get('settings.delivered_order_status'),
                \Config::get('settings.rejected_order_status'),
            ];

            $filter_array = array_diff( $filter_array, [$request->status] );
            $new_filter = array();

            foreach ($filter_array as $filter){
                if($filter>$request->status)
                    $new_filter[] = $filter;
            }


            if($this->user->hasRole('superadmin')) {
                $orders = OrderRestaurant::whereDoesntHave('status', function ($query) use ($new_filter) {
                    $query->whereIn('status', $new_filter);
                })
                    ->whereHas('status', function ($query) use ($request) {
                        $query->where('status', '=', $request->status);
                    })
                    ->whereBetween('created_at', [$from, $to]);
                if($request->restaurant_id)
                    $orders = $orders->where(['restaurant_id'=>$request->restaurant_id]);

                $this->data['reportData'] = $orders->orderby('id', 'asc')->get();
            }
            else
                $this->data['reportData'] = OrderRestaurant::where(['restaurant_id'=>$this->user->restaurant_id])
                    ->whereDoesntHave('status',function($query) use ($new_filter){
                        $query->whereIn('status',$new_filter);
                    })
                    ->whereHas('status',function($query)  use($request){
                        $query->where('status','=',$request->status);
                    })
                    ->whereBetween('created_at', [$from, $to])
                    ->orderby('id','asc')->get();


        }

        else {
            if ($this->user->hasRole('superadmin')) {
                $orders = OrderRestaurant::whereBetween('created_at', [$from, $to]);
                if($request->restaurant_id)
                    $orders = $orders->where(['restaurant_id'=>$request->restaurant_id]);

                $this->data['reportData'] = $orders->orderby('id', 'asc')->get();
            }
            else
                $this->data['reportData'] = OrderRestaurant::whereBetween('created_at', [$from, $to])
                    ->where(['restaurant_id' => $this->user->restaurant_id])->orderby('id', 'asc')->get();

        }
        return view('report.order_print',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function restaurants_statistics(Request $request){
        $this->data['selected'] = 'restaurants';
        $this->data['location'] = 'restaurants';
        $this->data['location_title'] = __('main.restaurants');
        $this->data['sub_menu'] = 'statistics';

        $this->data['reportData'] = Restaurant::where(['branch_of'=>NULL])->get();

        return view('report.restaurants',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customers_statistics(Request $request){
        $this->data['selected'] = 'customers';
        $this->data['location'] = 'customers';
        $this->data['location_title'] = __('main.customers');
        $this->data['sub_menu'] = 'statistics';

        $this->data['reportData'] = User::whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
        })->get();

        return view('report.customers',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users_statistics(Request $request){
        $this->data['selected'] = 'reports';
        $this->data['location'] = 'users';
        $this->data['location_title'] = __('main.users');
        $this->data['sub_menu'] = 'statistics';

        $this->data['reportData'] = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
        })->get();

        return view('report.users',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function most_orders(Request $request){
        $this->data['selected'] = 'most_orders';
        $this->data['location'] = 'most_orders';
        $this->data['location_title'] = __('main.most_orders');
        $this->data['sub_menu'] = 'orders';

        $this->data['from'] = date('Y-m-d');
        $this->data['to'] = date('Y-m-d');

        if ($request->isMethod('post')){
            $this->data['from'] = $request->from;
            $this->data['to'] = $request->to;
        }

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        if($this->user->hasRole(['superadmin','b']))
            $this->data['reportData'] = OrderDetail::groupBy('product_id')
                ->selectRaw('count(*) as total, product_id')
                ->orderBy('total','DESC')
                ->whereBetween('created_at',[$from,$to ])->get();

        else
            $this->data['reportData'] = OrderDetail::groupBy('product_id')
                ->selectRaw('count(*) as total, product_id')
                ->orderBy('total','DESC')
                ->whereHas('order_restaurant', function ($query)  {
                    $query->where(['restaurant_id'=>$this->user->restaurant_id]);
                })
                ->whereBetween('created_at',[$from,$to ])->get();


        return view('report.most_orders',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function most_ranked(Request $request){
        $this->data['selected'] = 'most_ranked';
        $this->data['location'] = 'most_ranked';
        $this->data['location_title'] = __('main.most_ranked');
        $this->data['sub_menu'] = 'orders';

        $this->data['from'] = date('Y-m-d');
        $this->data['to'] = date('Y-m-d');

        if ($request->isMethod('post')){
            $this->data['from'] = $request->from;
            $this->data['to'] = $request->to;
        }

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        if($this->user->hasRole(['superadmin','b']))
            $this->data['reportData'] = ProductReview::groupBy('product_id')
                ->selectRaw('ROUND(AVG(review_rank),1)  review_ranks, product_id')
                ->orderBy('review_ranks','DESC')
                ->where(['isActive'=>1])
                ->whereBetween('created_at',[$from,$to ])->get();

        else
            $this->data['reportData'] = ProductReview::groupBy('product_id')
                ->selectRaw('ROUND(AVG(review_rank),1)  review_ranks, product_id')
                ->orderBy('review_ranks','DESC')
                ->where(['isActive'=>1])
                ->whereHas('product', function ($query)  {
                    $query->whereHas('category', function ($query)  {
                        $query->where(['restaurant_id'=>$this->user->restaurant_id]);
                    });
                })
                ->whereBetween('created_at',[$from,$to ])->get();



        return view('report.most_ranked',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments(Request $request){
        $this->data['selected'] = 'payments';
        $this->data['location'] = 'payments';
        $this->data['location_title'] = __('main.payments');
        $this->data['sub_menu'] = 'payments';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        if ($request->isMethod('post')){
            $this->data['from'] = $request->from;
            $this->data['to'] = $request->to;
        }

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        if($this->user->hasRole(['superadmin','d']))
            $this->data['reportData'] = RestaurantBilling::whereBetween('created_at',[$from,$to ])->get();

        else
            $this->data['reportData'] = RestaurantBilling::whereBetween('created_at',[$from,$to ])
                ->where(['restaurant_id'=>$this->user->restaurant_id])
                ->get();

        return view('report.payment',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments_methods(Request $request){
        $this->data['selected'] = 'payments_methods';
        $this->data['location'] = 'payments_methods';
        $this->data['location_title'] = __('main.payment_methods');
        $this->data['sub_menu'] = 'payments';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        if ($request->isMethod('post')){
            $this->data['from'] = $request->from;
            $this->data['to'] = $request->to;
        }

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";


        if($this->user->hasRole(['superadmin','d']))
            $this->data['reportData'] = OrderRestaurant::groupBy('payment_id')
                ->selectRaw('payment_id, sum(sub_total) as sub_total')
                ->whereBetween('created_at',[$from,$to ])
                ->get();
        else
            $this->data['reportData'] = OrderRestaurant::groupBy('payment_id')
                ->selectRaw('payment_id, sum(sub_total) as sub_total')
                ->whereBetween('created_at',[$from,$to ])
                ->where(['restaurant_id'=>$this->user->restaurant_id])
                ->get();

        return view('report.payments_methods',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments_geo(Request $request){
        $this->data['selected'] = 'payments_geo';
        $this->data['location'] = 'payments_geo';
        $this->data['location_title'] = __('main.payments_geo');
        $this->data['sub_menu'] = 'payments';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        if ($request->isMethod('post')){
            $this->data['from'] = $request->from;
            $this->data['to'] = $request->to;
        }

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";


        if($this->user->hasRole(['superadmin','d']))
            $this->data['reportData'] = RestaurantBilling::groupBy('distance_exceeded')
                ->selectRaw('distance_exceeded, count(id) as counts')
                ->whereBetween('created_at',[$from,$to ])
                ->get();
        else
            $this->data['reportData'] = RestaurantBilling::groupBy('distance_exceeded')
                ->selectRaw('distance_exceeded, count(id) as counts')
                ->whereBetween('created_at',[$from,$to ])
                ->where(['restaurant_id'=>$this->user->restaurant_id])
                ->get();

        return view('report.payments_geo',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function financial(Request $request){
        $this->data['selected'] = 'financial';
        $this->data['location'] = 'financial';
        $this->data['location_title'] = __('main.financial');
        $this->data['sub_menu'] = 'financial';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        $this->data['restaurants'] = Restaurant::where(['branch_of'=>NULL])->get();
        return view('report.financial',$this->data);

    }

    public function financial_print(Request $request){

        $this->data['from'] = $request->from;
        $this->data['to'] = $request->to;

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";


        if($this->user->hasRole(['superadmin','d'])) {
            $this->data['credit'] = RestaurantBilling::selectRaw('sum(credit) as credit')
                ->whereBetween('created_at', [$from, $to]);
            if($request->restaurant_id)
                $this->data['credit'] =  $this->data['credit']->where(['restaurant_id' => $request->restaurant_id]);
            $this->data['credit'] =  $this->data['credit']->pluck('credit')[0];

            $this->data['debit'] = RestaurantBilling::selectRaw('sum(debit) as debit')
                ->whereBetween('created_at', [$from, $to]);
            if($request->restaurant_id)
                $this->data['debit'] =  $this->data['debit']->where(['restaurant_id' => $request->restaurant_id]);
            $this->data['debit'] =  $this->data['debit']->pluck('debit')[0];

            $this->data['total'] = RestaurantBilling::selectRaw('sum(sub_total) as total')
                ->whereBetween('created_at', [$from, $to]);
            if($request->restaurant_id)
                $this->data['total'] =  $this->data['total']->where(['restaurant_id' => $request->restaurant_id]);
            $this->data['total'] =$this->data['total']->pluck('total')[0];

            $this->data['counts'] = RestaurantBilling::selectRaw('count(id) as counts')
                ->whereBetween('created_at', [$from, $to]);
            if($request->restaurant_id)
                $this->data['counts'] =  $this->data['counts']->where(['restaurant_id' => $request->restaurant_id]);
            $this->data['counts'] =$this->data['counts']->pluck('counts')[0];


            $this->data['reportData'] = RestaurantBilling::whereBetween('created_at', [$from, $to]);
            if($request->restaurant_id)
                $this->data['reportData'] =  $this->data['reportData']->where(['restaurant_id' => $request->restaurant_id]);
            $this->data['reportData'] =  $this->data['reportData']->get();
        }
        else {

            $this->data['credit'] = RestaurantBilling::selectRaw('sum(credit) as credit')
                ->whereBetween('created_at', [$from, $to])
                ->where(['restaurant_id' => $this->user->restaurant_id])
                ->pluck('credit')[0];

            $this->data['debit'] = RestaurantBilling::selectRaw('sum(debit) as debit')
                ->whereBetween('created_at', [$from, $to])
                ->where(['restaurant_id' => $this->user->restaurant_id])
                ->pluck('debit')[0];

            $this->data['total'] = RestaurantBilling::selectRaw('sum(sub_total) as total')
                ->whereBetween('created_at', [$from, $to])
                ->where(['restaurant_id' => $this->user->restaurant_id])
                ->pluck('total')[0];

            $this->data['counts'] = RestaurantBilling::selectRaw('count(id) as counts')
                ->whereBetween('created_at', [$from, $to])
                ->where(['restaurant_id' => $this->user->restaurant_id])
                ->pluck('counts')[0];


            $this->data['reportData'] = RestaurantBilling::whereBetween('created_at', [$from, $to])
                ->where(['restaurant_id' => $this->user->restaurant_id])
                ->get();
        }

        return view('report.financial_print',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function financial_bills(Request $request){
        $this->data['selected'] = 'financial_bills';
        $this->data['location'] = 'financial_bills';
        $this->data['location_title'] = __('main.financial_bills');
        $this->data['sub_menu'] = 'financial';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        $this->data['payment_methods'] = PaymentMethod::all();
        $this->data['restaurants'] = Restaurant::where(['branch_of'=>NULL])->get();
        return view('report.financial_bills',$this->data);

    }

    public function financial_bills_print(Request $request){

        $this->data['from'] = $request->from;
        $this->data['to'] = $request->to;

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";


        if($this->user->hasRole(['superadmin','d'])) {

            $this->data['restaurant'] = Restaurant::find($request->restaurant_id);

            $this->data['reportData'] = RestaurantBilling::whereBetween('created_at', [$from, $to])
                ->where(['restaurant_id' => $request->restaurant_id])
                ->where(['payment_id' => $request->payment_method]);
            if($request->paid==0)
                $this->data['reportData'] = $this->data['reportData']->where(['paid'=>0]);
            elseif($request->paid==1)
                $this->data['reportData'] = $this->data['reportData']->where(['paid'=>1]);

            $this->data['reportData'] = $this->data['reportData']->get();

        }
        else {

            $this->data['restaurant'] = $this->user->restaurant;

            $this->data['reportData'] = RestaurantBilling::whereBetween('created_at', [$from, $to])
                ->where(['restaurant_id' => $this->user->restaurant_id])
                ->where(['payment_id' => $request->payment_method]);
            if($request->paid==0)
                $this->data['reportData'] = $this->data['reportData']->where(['paid'=>0]);
            elseif($request->paid==1)
                $this->data['reportData'] = $this->data['reportData']->where(['paid'=>1]);

            $this->data['reportData'] = $this->data['reportData']->get();
        }

        $this->data['payment_method'] = PaymentMethod::find($request->payment_method);
        return view('report.financial_bills_print',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function financial_paid(Request $request){
        $this->data['selected'] = 'financial_paid';
        $this->data['location'] = 'financial_paid';
        $this->data['location_title'] = __('main.financial_paid');
        $this->data['sub_menu'] = 'financial';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        $this->data['payment_methods'] = PaymentMethod::all();
        return view('report.financial_paid',$this->data);

    }

    public function financial_paid_print(Request $request){

        $this->data['from'] = $request->from;
        $this->data['to'] = $request->to;

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";



        if($request->payment_method==1)
            $this->data['reportData'] = RestaurantBilling::groupby('restaurant_id')
                ->selectRaw('restaurant_id,sum(credit) as total,count(id) as counts')
                ->where(['payment_id'=>$request->payment_method,'paid'=>1])
                ->whereBetween('paid_at', [$from, $to])->get();
        else
            $this->data['reportData'] = RestaurantBilling::groupby('restaurant_id')
                ->selectRaw('restaurant_id,sum(debit) as total,count(id) as counts')
                ->where(['payment_id'=>$request->payment_method,'paid'=>1])
                ->whereBetween('paid_at', [$from, $to])->get();



        $this->data['payment_method'] = PaymentMethod::find($request->payment_method);

        return view('report.financial_paid_print',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function financial_not_paid(Request $request){
        $this->data['selected'] = 'financial_not_paid';
        $this->data['location'] = 'financial_not_paid';
        $this->data['location_title'] = __('main.financial_not_paid');
        $this->data['sub_menu'] = 'financial';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";

        $this->data['payment_methods'] = PaymentMethod::all();
        return view('report.financial_not_paid',$this->data);

    }

    public function financial_not_paid_print(Request $request){

        $this->data['from'] = $request->from;
        $this->data['to'] = $request->to;

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";



        if($request->payment_method==1)
            $this->data['reportData'] = RestaurantBilling::groupby('restaurant_id')
                ->selectRaw('restaurant_id,sum(credit) as total,count(id) as counts')
                ->where(['payment_id'=>$request->payment_method,'paid'=>0])
                ->whereBetween('created_at', [$from, $to])->get();
        else
            $this->data['reportData'] = RestaurantBilling::groupby('restaurant_id')
                ->selectRaw('restaurant_id,sum(debit) as total,count(id) as counts')
                ->where(['payment_id'=>$request->payment_method,'paid'=>0])
                ->whereBetween('created_at', [$from, $to])->get();



        $this->data['payment_method'] = PaymentMethod::find($request->payment_method);

        return view('report.financial_not_paid_print',$this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function support(Request $request){
        $this->data['selected'] = 'support';
        $this->data['location'] = 'support';
        $this->data['location_title'] = __('main.support');
        $this->data['sub_menu'] = 'support';

        $this->data['from'] = date('Y-m-d ');
        $this->data['to'] = date('Y-m-d');

        if ($request->isMethod('post')){
            $this->data['from'] = $request->from;
            $this->data['to'] = $request->to;
        }

        $from = $this->data['from']." 00:00:00";
        $to = $this->data['to']." 23:59:59";


        $this->data['CustomerMessage'] = CustomerMessage::where(['message_type'=>1])
            ->whereBetween('created_at',[$from,$to ])
            ->count();

        $this->data['restaurantMessage'] = UserMessage::where(['message_type'=>1])
            ->whereBetween('created_at',[$from,$to ])
            ->count();


        return view('report.support',$this->data);

    }
}

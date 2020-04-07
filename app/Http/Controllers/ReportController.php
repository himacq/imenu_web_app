<?php

namespace App\Http\Controllers;

use App\Models\CustomerMessage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderRestaurant;
use App\Models\OrderRestaurantStatus;
use App\Models\ProductReview;
use App\Models\UserMessage;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->change_language();
        $this->middleware('role:admin||superadmin||b||c');
        $this->data['menu'] = 'reports';


    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders(Request $request){
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

        if($this->user->hasRole('superadmin'))
            $this->data['reportData'] = OrderRestaurantStatus::where(['status'=>7])
                ->whereBetween('created_at',[$from,$to ])->get();

        else
            $this->data['reportData'] = OrderRestaurantStatus::where(['status'=>7])
                ->whereBetween('created_at',[$from,$to ])
                ->whereHas('order_restaurant', function ($query)  {
                    $query->where(['restaurant_id'=>$this->user->restaurant_id]);
                })
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


        if($this->user->hasRole('superadmin'))
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

<?php

namespace App\Http\Controllers;

use App\Models\RestaurantBilling;
use App\Models\UserAddress;
use Illuminate\Http\Request;

use App\Models\OrderDetail;
use App\Models\OrderRestaurantStatus;
use App\Models\Lookup;
use App\Models\OrderRestaurant;
use App\Models\UserReview;

use DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->change_language();
        $this->middleware('role:admin||superadmin');
        $this->data['menu'] = 'sales';
        $this->data['selected'] = 'orders';
        $this->data['location'] = 'orders';
        $this->data['location_title'] = __('main.orders');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['sub_menu'] = 'orders';
        return view('order.index', $this->data);
    }

    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {
       if($this->user->hasRole('superadmin'))
           $orders = OrderRestaurant::all();
       else
        $orders = OrderRestaurant::where(['restaurant_id'=>$this->user->restaurant_id])->get();

          return DataTables::of($orders)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;


            })

              ->addColumn('customer', function ($model) {
                  return $model->order->customer->name;

              })
              ->addColumn('restaurant', function ($model) {
                  return $model->restaurant->name;

              })
            ->addColumn('status', function ($model) {
                if($model->status->count() > 0){
                if($model->status->last()->status_text->translate('display_text'))
                    return $model->status->last()->status_text->translate('display_text');
                }
                return __('main.undefine');

            })
            ->addColumn('qty', function ($model) {
                return $model->products->sum('qty');

            })

            ->addColumn('control', function ($model) {
                $id = $model->id;
                return '<a href="' . url("orders/" . $id . "/edit") . '" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-search"></i> '.__('main.view').'</a>';

            })
            ->rawColumns(['customer','control','status','qty','restaurant'])
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
        if($this->user->hasRole('superadmin'))
            $this->data['order'] = OrderRestaurant::where(['id'=>$id])->first();
        else
            $this->data['order'] = OrderRestaurant::where(['id'=>$id,'restaurant_id'=>$this->user->restaurant_id])->first();

        if(!$this->data['order'])
            return redirect()->route('orders.index')->with('status',trans('main.not_found'));

        $this->data['order_status'] = Lookup::where(
            ['parent_id'=>\Config::get('settings.order_status')])->get();


        return view('order.edit', $this->data);
    }

    public function print($id)
    {
        if($this->user->hasRole('superadmin'))
            $this->data['order'] = OrderRestaurant::where(['id'=>$id])->first();
        else
            $this->data['order'] = OrderRestaurant::where(['id'=>$id,'restaurant_id'=>$this->user->restaurant_id])->first();

        if(!$this->data['order'])
            return redirect()->route('orders.index')->with('status',trans('main.not_found'));


        return view('order.print', $this->data);
    }
    /**
     *
     * @param Request $request
     * @param type $id
     * @return type
     */

    public function update(Request $request,$id){

        if($request->order_status==\Config::get('settings.payment_order_status')) {
            $order_restaurant = OrderRestaurant::find($id);


            $order_distance = $this->distance(
                $order_restaurant->restaurant->latitude,
                $order_restaurant->restaurant->longitude,
                $order_restaurant->address->latitude,
                $order_restaurant->address->longitude,
                "K"
            );
            $distance_exceeded = false;
            // online payment to the application account
            if($order_restaurant->payment_id==1){

                if($order_distance>$order_restaurant->restaurant->distance){
                    // apply discount on commision
                    $commision = $order_restaurant->restaurant->commision*$order_restaurant->restaurant->discount/100;
                    $distance_exceeded = true;
                }
                else{
                    $commision = $order_restaurant->restaurant->commision;
                }

                $debit = 0;
                $credit = $order_restaurant->sub_total -
                    ($order_restaurant->sub_total*$commision/100);
            }
            else{
                // cash on delivery to the restaurant account
                if($order_distance>$order_restaurant->restaurant->distance){
                    // apply discount on commision
                    $commision = $order_restaurant->restaurant->commision*$order_restaurant->restaurant->discount/100;
                    $distance_exceeded = true;
                }
                else{
                    $commision = $order_restaurant->restaurant->commision;
                }

                $credit = 0;
                $debit =($order_restaurant->sub_total*$commision/100);
            }


        }


        OrderRestaurantStatus::create([
            'order_restaurant_id'=>$id,
            'status'=>$request->order_status
        ]);

        RestaurantBilling::create([
            'restaurant_id'=>$order_restaurant->restaurant_id,
            'payment_id'=>$order_restaurant->payment_id,
            'sub_total'=>$order_restaurant->sub_total,
            'order_id'=>$order_restaurant->order_id,
            'order_restaurant_id'=>$order_restaurant->id,
            'commision'=>$order_restaurant->restaurant->commision,
            'discount'=>$order_restaurant->restaurant->discount,
            'restaurant_distance'=>$order_restaurant->restaurant->distance,
            'order_distance'=>$order_distance,
            'distance_exceeded'=>$distance_exceeded,
            'credit'=>$credit,
            'debit'=>$debit
        ]);

        return redirect()->route('orders.edit',$id)->with('status', trans('main.success'));
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return round($miles * 1.609344,2);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
    /**
     *
     * @param Request $request
     * @param type $id
     * @return type
     */
     public function review_customer(Request $request,$id){
         $order = OrderRestaurant::where(['id'=>$id])->first();
         UserReview::create([
            'order_restaurant_id'=>$id,
            'user_id'=>$order->order->customer->id,
             'review_text'=>$request->review_text,
             'review_rank'=>$request->review_rank,
             'isActive'=>1
        ]);

        return redirect()->route('orders.edit',$id)->with('status', trans('main.success'));
    }
}

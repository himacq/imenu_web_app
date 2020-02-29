<?php

namespace App\Http\Controllers;

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
        $this->middleware('permission:orders-manage');
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
            ->rawColumns(['customer','control','status','qty'])
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
    /**
     * 
     * @param Request $request
     * @param type $id
     * @return type
     */
    
    public function update(Request $request,$id){
        OrderRestaurantStatus::create([
            'order_restaurant_id'=>$id,
            'status'=>$request->order_status
        ]);
        
        return redirect()->route('orders.edit',$id)->with('status', trans('main.success'));
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

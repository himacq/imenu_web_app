<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

use DataTables;
class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->change_language();
        $this->middleware('role:superadmin');
        $this->data['menu'] = 'system';
        $this->data['selected'] = 'system';
        $this->data['location'] = 'payment_methods';
        $this->data['location_title'] = __('main.payment_methods');
        $this->data['sub_menu'] = 'payment_methods';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payment.index', $this->data);
    }

    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {
            $methods = PaymentMethod::all();

        return DataTables::of($methods)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;


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

            ->addColumn('control', function ($model) {
                $id = $model->id;
                $html =  "<a class='btn btn-primary btn-sm' href = '" . url("payment_methods/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ";
                if(!count($model->restaurants))
                    $html.= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";

                return $html;
            })
            ->rawColumns(['control','active'])
            ->make(true);

    }

    /**
     *
     * @param Request $request
     * @return type
     */
    public function activeMethod(Request $request)
    {
        $isActive = $request->active;
        $method= PaymentMethod::find($request->id);

        $method->update([
            'isActive' => $isActive,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $method = PaymentMethod::create([
            'name' => $request->name,
            'api_url'=>$request->api_url,
            'isActive'=>$request->isActive,
        ]);


        if($method){
            $this->new_translation($method->id,'ar','payment_methods','name',$request['name_ar']);
            $this->new_translation($method->id,'tr','payment_methods','name',$request['name_tr']);

        }

        return redirect()->route('payment_methods.index')->with('status', trans('main.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $method = PaymentMethod::find($id);
        $method->name_ar = $method->translate('name','ar');
        $method->name_tr = $method->translate('name','tr');

        $this->data['method'] = $method;

        return view('payment.edit', $this->data);
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
        $method = PaymentMethod::find($id);

        $method->update([
            'name' => $request->name,
            'api_url'=>$request->api_url,
            'isActive'=>$request->isActive,
        ]);

        if($method){
            $this->new_translation($method->id,'ar','payment_methods','name',$request['name_ar']);
            $this->new_translation($method->id,'tr','payment_methods','name',$request['name_tr']);

        }

        return redirect()->route('payment_methods.index')->with('status', trans('main.success'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

        $method = PaymentMethod::find($id);

        try {
            if($method->delete()){
                $this->delete_translation($id, 'payment_methods');
            }
            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }
}

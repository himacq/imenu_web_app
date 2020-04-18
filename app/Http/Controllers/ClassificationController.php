<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Classification;

class ClassificationController extends Controller
{

    public function __construct()
    {
        $this->change_language();
        $this->middleware('role:superadmin');
        $this->data['menu'] = 'system';
        $this->data['selected'] = 'system';
        $this->data['location'] = 'classifications';
        $this->data['location_title'] = __('main.classifications');
        $this->data['sub_menu'] = 'classification';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('classification.index', $this->data);
    }

    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {
        $classifications = Classification::all();

          return DataTables::of($classifications)
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
                $html =  "<a class='btn btn-primary btn-sm' href = '" . url("classifications/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ";

                if(!count($model->restaurants))
                  $html.= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";

                $html.='<a href="' . url("classifications/" . $id ) . '"  class="btn btn-sm blue"><i class="fa fa-file-o"></i> '.__('main.copy').' </a>';


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
     public function activeClassification(Request $request)
    {
        $isActive = $request->active;
        $classification = Classification::find($request->id);


        $classification->update([
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
        return view('classification.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $classification = Classification::create([
                 'name' => $request->name,
                'isActive'=>$request->isActive,
             ]);

       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$classification->id.".".$file->getClientOriginalExtension();

                //Move Uploaded File
                $destinationPath = 'uploads/classifications/';
                $file->move($destinationPath,$filename);

           $classification->update([
                 'image' => $filename
             ]);

        }
        if($classification){
        $this->new_translation($classification->id,'ar','classifications','name',$request['name_ar']);
        $this->new_translation($classification->id,'tr','classifications','name',$request['name_tr']);

        }

        return redirect()->route('classifications.index')->with('status', trans('main.success'));
    }

    /**
     * Store a copied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_copy(Request $request)
    {

        $classification = Classification::create([
                 'name' => $request->name,
                'isActive'=>$request->isActive,
             ]);

       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$classification->id.".".$file->getClientOriginalExtension();
                //Move Uploaded File
                $destinationPath = 'uploads/classifications/';
                $file->move($destinationPath,$filename);

        }
        else
            $filename = $request->old_image;


        $classification->update([
                 'image' => $filename
             ]);

        if($classification){
        $this->new_translation($classification->id,'ar','classifications','name',$request['name_ar']);
        $this->new_translation($classification->id,'tr','classifications','name',$request['name_tr']);

        }

        return redirect()->route('classifications.index')->with('status', trans('main.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classification = Classification::find($id);

        $classification->name_ar = $classification->translate('name','ar');
        $classification->name_tr = $classification->translate('name','tr');

        $this->data['classification'] = $classification;
        $this->data['copy'] = true;

        return view('classification.edit', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classification = Classification::find($id);

        $classification->name_ar = $classification->translate('name','ar');
        $classification->name_tr = $classification->translate('name','tr');

        $this->data['classification'] = $classification;
        $this->data['copy'] = false;

        return view('classification.edit', $this->data);
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
        $classification = Classification::find($id);

        $classification->update([
                 'name' => $request->name,
                'isActive'=>$request->isActive,
             ]);

       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$classification->id.".".$file->getClientOriginalExtension();

                //Move Uploaded File
                $destinationPath = 'uploads/classifications/';
                $file->move($destinationPath,$filename);

           $classification->update([
                 'image' => $filename
             ]);

        }
        if($classification){
        $this->new_translation($classification->id,'ar','classifications','name',$request['name_ar']);
        $this->new_translation($classification->id,'tr','classifications','name',$request['name_tr']);

        }

        return redirect()->route('classifications.index')->with('status', trans('main.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

        $classification = Classification::find($id);

        try {
            if($classification->delete()){
                $this->delete_translation($id, 'classifications');
            }
            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }
}

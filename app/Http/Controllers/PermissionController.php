<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddPermissionRequest;

use App\Models\Permission;
use DataTables;
class PermissionController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->change_language();
        $this->middleware('role:superadmin');
        $this->data['menu'] = 'system';
        $this->data['selected'] = 'system';
        $this->data['location'] = 'permissions';
        $this->data['location_title'] = __('main.permissions');

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $this->data['sub_menu'] = 'permissions';
        return view('permission.index', $this->data);
    }
    
    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {
        
        $permissions = Permission::all();
          return DataTables::of($permissions)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;
            })->EditColumn('display_name', function ($model) {
                return $model->translate('display_name');

            })->EditColumn('description', function ($model) {
                return $model->translate('description');

            })->addColumn('control', function ($model) {
                $id = $model->id;
                return "<a class='btn btn-primary btn-sm' href = '" . url("permissions/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> "
                    . "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";

            })
            ->rawColumns(['active','control'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['sub_menu'] = 'permissions';
        return view('permission.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPermissionRequest $request)
    {
        
        $permission = Permission::create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'description'=>$request->description
        ]);
        if($permission){
        $this->new_translation($permission->id,'ar','permissions','display_name',$request['display_name_ar']);
        $this->new_translation($permission->id,'ar','permissions','description',$request['description_ar']);
        
        $this->new_translation($permission->id,'tr','permissions','display_name',$request['display_name_tr']);
        $this->new_translation($permission->id,'tr','permissions','description',$request['description_tr']);
        
        }
        return redirect()->route('permissions.index')->with('status',trans('main.success'));
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
        $this->data['sub_menu'] = 'permissions';
        
        $permission = Permission::find($id);
        
        $permission->display_name_ar = $permission->translate('display_name','ar');
        $permission->description_ar = $permission->translate('description','ar');
        $permission->display_name_tr = $permission->translate('display_name','tr');
        $permission->description_tr = $permission->translate('description','tr');
        
        $this->data['permission'] = $permission;
        
        return view('permission.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddPermissionRequest $request, $id)
    {
       $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        if($permission){
        $this->new_translation($permission->id,'ar','permissions','display_name',$request['display_name_ar']);
        $this->new_translation($permission->id,'ar','permissions','description',$request['description_ar']);
        
        $this->new_translation($permission->id,'tr','permissions','display_name',$request['display_name_tr']);
        $this->new_translation($permission->id,'tr','permissions','description',$request['description_tr']);
        
        }
        return redirect()->route('permissions.index')->with('status',trans('main.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $permission = Permission::find($id);
        if($permission->name == 'system-manage')  return response()->json(['status' => false]);
        
        if($permission->delete()){
            $this->delete_translation($id, 'permissions');
        }
        return response()->json(['status' => true]);
    }
}

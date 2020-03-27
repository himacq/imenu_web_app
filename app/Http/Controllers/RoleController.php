<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use DataTables;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->change_language();
        $this->middleware('role:superadmin');
        $this->data['menu'] = 'system';
        $this->data['selected'] = 'system';
        $this->data['location'] = 'roles';
        $this->data['location_title'] = __('main.roles');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['sub_menu'] = 'roles';
        return view('role.index', $this->data);
    }

    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {

        $roles = Role::all();
          return DataTables::of($roles)
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
                return "<a class='btn btn-primary btn-sm' href = '" . url("roles/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> "
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
        $this->data['sub_menu'] = 'roles';
        $this->data['permissions'] = Permission::all();
        return view('role.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoleRequest $request)
    {
        /*if(!$request->permission){
            return back()
            ->withInput()
            ->withErrors(['permission.required',trans('roles.enter_permissions')]);
        }*/
        $role = Role::create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'description'=>$request->description
        ]);
        if($role){
        $this->new_translation($role->id,'ar','roles','display_name',$request['display_name_ar']);
        $this->new_translation($role->id,'ar','roles','description',$request['description_ar']);

        $this->new_translation($role->id,'tr','roles','display_name',$request['display_name_tr']);
        $this->new_translation($role->id,'tr','roles','description',$request['description_tr']);


            if($request->permission) {
                foreach ($request->permission as $key => $value) {
                    $role->attachPermission($value);
                }
            }
        }
        return redirect()->route('roles.index')->with('status',trans('main.success'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $this->data['permissions'] = Permission::all();
        $this->data['role_permissions'] = $role->rolePermissions->pluck('permission_id')->toArray();

        $role->display_name_ar = $role->translate('display_name','ar');
        $role->description_ar = $role->translate('description','ar');
        $role->display_name_tr = $role->translate('display_name','tr');
        $role->description_tr = $role->translate('description','tr');

        $this->data['role'] = $role;

        return view('role.edit', $this->data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        /* if(!$request->permission){
            return back()
            ->withInput()
            ->withErrors(['permission.required',trans('roles.enter_permissions')]);
        }*/

        $role = Role::find($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        if($role){
        $this->new_translation($role->id,'ar','roles','display_name',$request['display_name_ar']);
        $this->new_translation($role->id,'ar','roles','description',$request['description_ar']);

        $this->new_translation($role->id,'tr','roles','display_name',$request['display_name_tr']);
        $this->new_translation($role->id,'tr','roles','description',$request['description_tr']);


        $role->detachPermissions($role->rolePermissions);

            if($request->permission) {
                foreach ($request->permission as $key => $value) {
                    $role->attachPermission($value);
                }
            }
        }
        return redirect()->route('roles.index')->with('status',trans('main.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if($role->name == 'superadmin')  return response()->json(['status' => false]);

        if($role->delete()){
            $this->delete_translation($id, 'roles');
        }
        return response()->json(['status' => true]);
    }


}

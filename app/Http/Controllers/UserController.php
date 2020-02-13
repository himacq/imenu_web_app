<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\Permission;
use App\Models\Rank;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Route;
use Auth;

use Illuminate\Http\Request;
use Validator;
use Session;
use DataTables;

use App;
class UserController extends Controller
{

    
    
    public function __construct()
    {
        $this->middleware(['role:admin'])->except(['profile', 'changePassword', 'updateInfo']);

//        $this->middleware('permission:user_display|user_update|user_delete', ['only' => ['index']]);
//        $this->middleware('permission:user_create', ['only' => ['create']]);
//        $this->middleware('permission:user_update', ['only' => ['edit']]);
//        $this->middleware('permission:user_delete', ['only' => ['destroy']]);


        $this->change_language();
        $this->data['menu'] = 'users';
        $this->data['selected'] = 'users';
        $this->data['location'] = trans('main.users');
        $this->data['location_title'] = trans('main.users');

    }


 
    public function index()
    {
        $this->data['sub_menu'] = 'Display-user';
        return view('user.index', $this->data);
    }

    public function profile()
    {
        if (Auth::user()->id) {
            $this->data['sub_menu'] = '';
            $this->data['location_title'] = 'My profile';
            $this->data['location'] = 'users/profile';
            $this->data['user'] = User::find(Auth::user()->id);
            return view('user.profile', $this->data);
        } else return redirect('/');
    }

    public function updateInfo(UpdateUserInfoRequest $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();

        return redirect()->route('users.profile')->with('status', 'Update is done successfully');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if (Auth::user()->id) {
            // check if the old password is correct
            $user = User::where('id', Auth::user()->id)->first();
            if (Hash::check($request->old_password, $user->user_pass)) {
                $user->update(['user_pass' => Hash::make($request->new_password)]);
                return back()->with('status', 'Change password is done successfully');
            } else return back()->with('error', 'The old password is error');
            //$this->data['user'] = User::find(Auth::user()->id);

        } else return redirect('/');
    }

    /**
     * to view user create form
     * @return type
     */
    public function create()
    {
        $this->data['sub_menu'] = 'users-create';
        $this->data['roles'] = Role::all();
        return view('user.create', $this->data);
    }

    public function store(AddUserRequest $request)
    {
        
        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
    
        ]);
        
        foreach ($request->role as $key => $value) {
            $user->attachRole($value);
        }
        
        return redirect()->route('users.index')->with('status', trans('main.success'));
    }

    public function edit($id)
    {
        $this->data['sub_menu'] = 'users-edit';
        $this->data['user'] = User::find($id);
        $this->data['roles'] = Role::all();
        $this->data['user_roles'] = $this->data['user']->roles->pluck('id', 'id')->toArray();
        return view('user.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        
        
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->mobile = $request->mobile;
        $user->isActive = $request->isActive;
        $user->news_letter = $request->news_letter;
        
        if ($request->password != '') $user->password = bcrypt($request->password);
        $user->username = $request->username;


        $user->roles()->detach();
       if(!empty($request->role)) {
           foreach ($request->role as $value) {
                $user->attachRole($value);
           }
       }

        $user->update();

        return redirect()->route('users.index')->with('status', 'Update is done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

        $user = User::whereId($id);
        try {
            $user->delete();
            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }

    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {
        if ($request->status) {
            if($request->status==-1)$request->status=0;
            $user = User::where('id','!=',1)->where('isActive', '=', $request->status)->get();
        } else {
            $user = User::where('id','!=',1)->get();
        }
        return DataTables::of($user)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
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
                              <input  type="radio" value="-1" name="multifeatured_module[module_id][status]">OFF</label>
                           </div>';


            })
            
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })->addColumn('control', function ($model) {
                $id = $model->id;
                return "<a class='btn btn-primary btn-sm' href = '" . url("users/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> "
                    . "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";

            })
            ->rawColumns(['active','control'])
            ->make(true);

    }

    public function activeUser(Request $request)
    {
        $user_id = $request->id;
        $isActive = $request->active;

        $user = User::find($user_id);
        $user->update([
            'isActive' => $isActive,
        ]);
        $user->deleteToken();


    }

}

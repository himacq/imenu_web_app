<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\AppReview;
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
        $this->middleware(['role:admin||superadmin||b||c||d||e'])->except(['profile', 'changePassword', 'updateUserInfo','logout']);

        $this->change_language();
        $this->data['menu'] = 'users';
        $this->data['selected'] = 'users';
        $this->data['location'] = 'users';
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
            $this->data['sub_menu'] = 'Display-user';
            $this->data['user'] = User::find(Auth::user()->id);
            return view('user.profile', $this->data);
        }

        else return redirect('/');
    }

    public function updateUserInfo(UpdateUserInfoRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->mobile = $request->mobile;
        $user->news_letter = $request->news_letter;
        unset($user->isAdmin);
        if ($request->password != '') $user->password = bcrypt($request->password);

        $user->update();

        if($request->avatar){
            $file = $request->file('avatar');
            $filename = "avatar-".$user->id.".".$file->getClientOriginalExtension();

            //Move Uploaded File
            $destinationPath = 'uploads/avatars/';
            $file->move($destinationPath,$filename);

            $user->update([
                'avatar' => $filename
            ]);

        }

        return redirect()->route('users.profile')->with('status', trans('main.success'));
    }


    /**
     * to view user create form
     * @return type
     */
    public function create()
    {
        $this->data['sub_menu'] = 'users-create';
        if($this->user->hasRole('superadmin'))
            $this->data['roles'] = Role::all();
        elseif($this->user->hasRole('c'))
            $this->data['roles'] = Role::whereIn('name',['c1','c2'])->get();
        elseif($this->user->hasRole('d'))
            $this->data['roles'] = Role::where('name','=','d')->get();
        else
        $this->data['roles'] = Role::where('id','>',1)->get();

        return view('user.create', $this->data);
    }

    public function store(AddUserRequest $request)
    {

        if($this->user->hasRole(['c','d']) && !$request->role){
            return back()
                ->withInput()
                ->withErrors([trans('users.select_role')]);
        }


        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'restaurant_id'=>$this->user->restaurant_id

        ]);

        if($request->avatar){
            $file = $request->file('avatar');
            $filename = "avatar-".$user->id.".".$file->getClientOriginalExtension();

            //Move Uploaded File
            $destinationPath = 'uploads/avatars/';
            $file->move($destinationPath,$filename);

            $user->update([
                'avatar' => $filename
            ]);

        }

        if(!empty($request->role)) {
            foreach ($request->role as $key => $value) {
                $user->attachRole($value);
            }
        }


        return redirect()->route('users.index')->with('status', trans('main.success'));
    }

    /**
     *
     * @param type $id
     * @return type
     */
        public function check_user_authority($user2){
        if( $this->user->hasRole('superadmin'))
                return false ;

        $users = $this->get_all_users_restaurant($this->user->restaurant_id);
        foreach($users as $user){
            if($user2->id == $user->id)
                return false;
        }


       return true;

    }
    /**
     *
     * @param type $id
     * @return type
     */
    public function edit($id)
    {
       $user = User::find($id);

       if(!$user)
           return redirect()->route('users.index')->with('status', trans('main.not_found'));

        if(!$this->user->hasRole(['c','d','e']) && $this->check_user_authority($user))
           return  redirect()->route('logout');

        $this->data['sub_menu'] = 'users-edit';
        $this->data['user'] = $user;
        if($this->user->hasRole('superadmin'))
            $this->data['roles'] = Role::all();
        elseif($this->user->hasRole('c'))
            $this->data['roles'] = Role::whereIn('name',['c1','c2'])->get();
        elseif($this->user->hasRole('d'))
            $this->data['roles'] = Role::where('name','=','d')->get();
        else
            $this->data['roles'] = Role::where('id','>',1)->get();

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
        if($this->user->hasRole(['c','d']) && !$request->role){
            return back()
                ->withInput()
                ->withErrors([trans('users.select_role')]);
        }

        $user = User::find($id);

        if(!$this->user->hasRole(['c','d','e']) && $this->check_user_authority($user))
            return  redirect()->route('logout');

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

        if($request->avatar){
            $file = $request->file('avatar');
            $filename = "avatar-".$user->id.".".$file->getClientOriginalExtension();

            //Move Uploaded File
            $destinationPath = 'uploads/avatars/';
            $file->move($destinationPath,$filename);

            $user->update([
                'avatar' => $filename
            ]);

        }

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
            $users = User::where('id','!=',$this->user->id)->where('isActive', '=', $request->status);
        } else {
            $users = User::where('id','!=',$this->user->id);
        }

        if($this->user->hasRole('superadmin'))
            $users_data = $users->get();
        else if($this->user->hasRole(['b','e'])){
            $users_data =User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['superadmin','admin','a','b','c','c1','c2','d','e']);
            })->get();

        }
        else if($this->user->hasRole('c')){
            $users_data =User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['c','c1','c2']);
            })->get();

        }
        else if($this->user->hasRole('d')){
            $users_data =User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['d']);
            })->get();

        }
        else
            $users_data = $this->get_all_users_restaurant($this->user->restaurant_id);

        return DataTables::of($users_data)
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
                              <input  type="radio" value="0" name="multifeatured_module[module_id][status]">OFF</label>
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activeUser(Request $request)
    {
        $user_id = $request->id;
        $isActive = $request->active;

        $user = User::find($user_id);
        if($this->check_user_authority($user))
           return  redirect()->route('logout');


        $user->update([
            'isActive' => $isActive,
        ]);
        $user->deleteToken();


    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users_app_reviews(){
        return view('user.users_app_reviews',$this->data);
    }

    public function reviewsContentListData(Request $request)
    {

        $reviews = AppReview::all();

        return DataTables::of($reviews)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->addColumn('status', function ($model) {
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
            ->addColumn('user', function ($model) {
                if($model->user)
                return '<a href="'.url('users/'.$model->user_id.'/edit').'" target="_blank">'.$model->user->name.'</a>';

                return trans('main.undefined');
            })

            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })
            ->rawColumns(['status','user'])
            ->make(true);

    }

    public function activeReview(Request $request)
    {
        $isActive = $request->active;

        $review = AppReview::find($request->id);

        $review->update([
            'isActive' => $isActive,
        ]);

    }


}

<?php


namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use App\Models\User;
use App\Models\Role;
use App\Models\UserAddress;



class CoreApiController extends Controller
{
    use AuthenticatesUsers;
    
    protected $user = null;
    public function __construct()
    {
      $this->user =  Auth::guard('api')->user();
      if($this->user)
        App::setLocale($this->user->language_id);
    }
    
       
    //
    // users API
    //*********************/
    
     /**
     * 
     * @param Request $request
     * @return type
     */
      public function register(Request $request){

          if($request->language_id)
              App::setLocale($request->language_id);
          
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'username' => $request->username,
            'isActive' => 0,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
        ]);

       $user->attachRole(Role::where('name', 'user')->first());

        $user->generateToken();

        return $this->response($user->toArray(), true,__('api.success'));
    }
    
     /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        if($request->language_id)
              App::setLocale($request->language_id);
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            if (!$user->isActive){
                return $this->response(null,false,__('auth.notActive'));
            }
        
            return $this->response($user->toArray(), true,__('api.success'));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        
        
        return $this->response(null,false,__('auth.failed'));
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function logout(Request $request)
    {
        $this->user->deleteToken();

        return $this->response(null,true,__('api.success'));
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function userProfile(Request $request)
    {
        return $this->response($this->user->toArray(), true,__('api.success'));
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
     public function updateUserProfile(Request $request){
         
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
            
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'language_id' => $request->language_id,
        ];
        
        $this->user->update($input);
        
        App::setLocale($request->language_id);
        
        return $this->response($this->user->toArray(), true,__('api.success'));
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
     public function updateLocation(Request $request){
        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
            
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        $input = [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];
        
        $this->user->update($input);
        

        return $this->response($this->user->toArray(), true,__('api.success'));
    }
    /**
     * 
     * @param Request $request
     * @return type
     */
    
    public function updatePassword(Request $request)
    {
        
         
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required',
            'password_confirm' => 'required|same:new_password'
            
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
       
        if (! Hash::check($request->old_password, $this->user->password)) {
            return $this->response(null, false,__('auth.password'));
        }
        $input = [
            'password' => bcrypt($request->new_password),
             ];
        
        $this->user->update($input);
        
        return $this->response(null, true,__('api.success'));
    }
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function createAddress(Request $request){

        $rules = [
            'street' => 'required|max:255',
            'city' => 'required|max:255',
            'governorate' => 'required|min:6',
            'zip_code' => 'required|min:4',
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
       
        $userAddress = UserAddress::create([
            'user_id' => $this->user->id,
            'city' => $request->city,
            'street' => $request->street,
            'house_no' => $request->house_no,
            'governorate' => $request->governorate,
            'zip_code' => $request->zip_code,
            'isDefault' => $request->isDefault,
        ]);

        return $this->response($userAddress->toArray(), true,__('api.success'));
    }
    
    
     /**
     * 
     * @param Request $request
     * @return type
     */
    public function updateAddress(Request $request){

        $rules = [
            'street' => 'required|max:255',
            'city' => 'required|max:255',
            'governorate' => 'required|min:6',
            'zip_code' => 'required|min:4',
            'id' => 'required|integer',
        ];
        
          $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        
        $address = UserAddress::where(['user_id'=>$this->user->id,'id'=>$request->id])->first();
        if (!$address) {
            return $this->response(null, false,__('api.not_found',['var'=>'address']));
        }
        
        if($request->isDefault){
            UserAddress::where(['user_id'=>$this->user->id])->update(['isDefault' => 0]);
        }
        $address->update([
            'city' => $request->city,
            'street' => $request->street,
            'house_no' => $request->house_no,
            'governorate' => $request->governorate,
            'zip_code' => $request->zip_code,
            'isDefault' => $request->isDefault,
        ]);

        return $this->response($address->toArray(), true,__('api.success'));
    }
    /**
     * 
     * @param type $id
     */
    public function deleteAddress($id){
        if (!$id) {
            return $this->response(null, false,__('api.not_found',['var'=>'address']));
        }
        $address = UserAddress::where(['user_id'=>$this->user->id,'id'=>$id])->first();
        if (!$address) {
            return $this->response(null, false,__('api.not_found',['var'=>'address']));
        }
        
        $address->delete();
      
        return $this->response($address->toArray(), true,__('api.success'));
        
    }
    
    public function listAddresses(){
      return $this->response($this->user->getAddresses, true,__('api.success'));

    }
    
    
}

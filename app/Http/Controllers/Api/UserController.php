<?php


namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Http\Resources\User as UserResource;

use App;
use App\Models\User;
use App\Models\Role;
use App\Models\UserAddress;
use App\Models\Cart;



class UserController extends ApiController
{
    use AuthenticatesUsers;

    public function __construct()
    {
        parent::__construct();
    }
    //
    // users API
    //*********************/

    public function review(Request $request){
        $rules = [
            'review_text' => 'required|min:3',
            'review_rank' => 'required|integer',
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }

        $review = App\Models\AppReview::create([
            'review_text' => $request->review_text,
            'review_rank' => $request->review_rank,
            'isActive' => 1,
            'user_id' => $this->user->id,
        ]);


        return $this->response($review->toArray(), true,__('api.success'));
    }

     /**
     *
     * @param Request $request
     * @return type
     */
      public function register(Request $request){
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
            'isActive' => 1,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
        ]);

       if($user){
           if($request->avatar) {
               $avatar = $this->storeImage($request->avatar, '/uploads/avatars/', 'avatar-' . $user->id);

               $user->update([
                   'avatar' => $avatar
               ]);
           }

           UserAddress::create([
               'user_id' => $user->id,
               'isDefault' => 1,
               'address_type' => $request->address_type,
               'description' => $request->description,
               'formated_address' => $request->formated_address,
               'latitude'=> $request->latitude,
               'longitude'=> $request->longitude
           ]);

           $user->attachRole(Role::where('name', 'user')->first());

           return $this->login($request);
       }



          return $this->response(null, false,$validate->errors()->first());
    }

     /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            $this->user = $this->guard()->user();
            $this->user->generateToken();

            if (!$this->user->isActive){
                return $this->response(null,false,__('auth.notActive'));
            }

            if($request->header('lang')){
            $this->user->update(['language_id' => $request->header('lang')]);
            }

            Cart::firstOrCreate(['user_id' => $this->user->id]);

            $user = new UserResource($this->user);
            return $user->additional(['status'=>true,'message'=>__('api.success')]);
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
        $user = new UserResource($this->user);
            return $user->additional(['status'=>true,'message'=>__('api.success')]);
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

        $this->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'isActive' => 1,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
        ]);

         if($request->avatar) {
             $avatar = $this->storeImage($request->avatar, '/uploads/avatars/', 'avatar-' . $this->user->id);

             $this->user->update([
                 'avatar' => $avatar
             ]);
         }


        App::setLocale($request->header('lang'));

         $user = new UserResource($this->user);
         return $user->additional(['status'=>true,'message'=>__('api.success')]);
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
            'city' => 'required|max:255'
        ];

          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        $isDefault = $request->isDefault;
       if($request->isDefault){
            UserAddress::where(['user_id'=>$this->user->id])->update(['isDefault' => 0]);
        }
        else $isDefault = 0;
        $userAddress = UserAddress::create([
            'user_id' => $this->user->id,
            'city' => $request->city,
            'street' => $request->street,
            'house_no' => $request->house_no,
            'governorate' => $request->governorate,
            'zip_code' => $request->zip_code,
            'isDefault' => $isDefault,
            'address_type' => $request->address_type,
            'description' => $request->description,
            'formated_address' => $request->formated_address,
            'house_name'=> $request->house_name,
            'floor_no'=> $request->floor_no,
            'apartment_no'=> $request->apartment_no,
            'latitude'=> $request->latitude,
            'longitude'=> $request->longitude
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

         $isDefault = $request->isDefault;
       if($request->isDefault){
            UserAddress::where(['user_id'=>$this->user->id])->update(['isDefault' => 0]);
        }
        else $isDefault = 0;
        $address->update([
            'city' => $request->city,
            'street' => $request->street,
            'house_no' => $request->house_no,
            'governorate' => $request->governorate,
            'zip_code' => $request->zip_code,
            'isDefault' => $isDefault,
            'address_type' => $request->address_type,
            'description' => $request->description,
            'formated_address' => $request->formated_address,
            'house_name'=> $request->house_name,
            'floor_no'=> $request->floor_no,
            'apartment_no'=> $request->apartment_no,
            'latitude'=> $request->latitude,
            'longitude'=> $request->longitude
        ]);

        return $this->response($address->toArray(), true,__('api.success'));
    }
    /**
     *
     * @param type $id
     */
    public function deleteAddress($id){
        if (!$id) {
            return $this->response(null, false,__('api.not_found'));
        }
        $address = UserAddress::where(['user_id'=>$this->user->id,'id'=>$id])->first();
        if (!$address) {
            return $this->response(null, false,__('api.not_found'));
        }

        $address->delete();

        return $this->response(null, true,__('api.success'));

    }

    public function listAddresses(){
      return $this->response($this->user->getAddresses, true,__('api.success'));

      }


}

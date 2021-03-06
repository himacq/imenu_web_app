<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Auth;
use App;

use App\Models\Translation;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\UserMessage;
use App\Models\CustomerMessage;

use DB;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $data = array();
    public $user;

    /**
     * to change the App local language based on the logged user's language
     */
    public function change_language() {

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            App::setLocale($this->user->language_id);

            if(($this->user->restaurant_id && $this->user->hasRole('admin'))){
                $this->user->isAdmin = true;
                $this->data['user'] = $this->user;
            }

            if(!$this->user->isActive){
                return redirect()->route('not_active_user');
            }


            return $next($request);
        });
    }



    /**
     * create a new translation for this record
     * @param type $record_id
     * @param type $language_id
     * @param type $model
     * @param type $field
     * @param type $record_text
     * @return type
     */

    public function new_translation($record_id,$language_id,$model,$field,$record_text){
        $translate_record =  Translation::updateOrCreate([
                    'record_id'=>$record_id,
                    'language_id'=>$language_id,
                    'model'=>$model,
                    'field'=>$field,
                ]);

        $translate_record->update(['display_text'=>$record_text]);

        return $translate_record;
    }

    /**
     * delete translation record
     * @param type $record_id
     * @param type $model
     * @return type
     */

    public function delete_translation($record_id,$model){
        $translate_record =  Translation::where([
                    'record_id'=>$record_id,
                    'model'=>$model,
                ])->delete();

        return $translate_record;
    }


    /**
     *
     * @param type $data
     * @param type $status
     * @return type
     */
    public function response($data, $status, $messages = null) {
        return response()->json(['status' => $status, 'message' => $messages, 'data' => $data], 200);
    }


    public function get_all_users_restaurant($restaurant_id){
        $restaurants = Restaurant::where(['branch_of'=>$restaurant_id])->get();
        $restaurant_array = array($restaurant_id);
        foreach($restaurants as $restaurant){
            $restaurant_array[] = $restaurant->id;
        }

        return User::whereNotIn('id',[$this->user->id])->whereIn('restaurant_id',$restaurant_array)->get();
    }

}

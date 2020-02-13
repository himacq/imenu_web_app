<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use App;

use App\Models\Translation;
class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $data = array();
    public $user;

    public function change_language() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            App::setLocale($this->user->language_id);
            return $next($request);
        });
    }

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
     * 
     * @param type $data
     * @param type $status
     * @return type
     */
    public function response($data, $status, $messages = null) {
        return response()->json(['status' => $status, 'message' => $messages, 'data' => $data], 200);
    }

}

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
use App\Models\Message;
use App\Models\MessageReply;

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
            
            if(!($this->user->restaurant_id || $this->user->hasRole('superadmin'))){
                return redirect()->route('logout');
            }
            
            /** 
             * count user's new messages
             */
            $new_messages = DB::select('SELECT DISTINCT messages.id FROM messages '
                    . 'left outer join `message_replies` '
                    . 'on messages.id=message_replies.message_id '
                    . ' where ((messages.sender_id='.$this->user->id.' or messages.receiver_id='.$this->user->id.' )'
                    . 'and (message_replies.`sender_id` !='.$this->user->id.' '
                    . 'AND message_replies.`isSeen` = 0))  '
                    . 'or (messages.receiver_id='.$this->user->id.' and messages.isSeen=0)'
                    . '');
            
            
            
            $messages = array();
            foreach($new_messages as $message){
                $messages[] = $message->id;
            }
            
            $this->data['new_messages'] = Message::whereIn('id',$messages)->get();
            /**
             * super admin new customer's new messages
             */
            if($this->user->hasRole('superadmin')){
            $customer_new_messages = DB::select('SELECT DISTINCT messages.id FROM messages '
                    . 'left outer join `message_replies` '
                    . 'on messages.id=message_replies.message_id '
                    . ' where ((messages.message_type=1 )'
                    . 'and (message_replies.`sender_id` !='.$this->user->id.' '
                    . 'AND message_replies.`isSeen` = 0))  '
                    . 'or (messages.message_type=1 and messages.isSeen=0)'
                    . '');
            
            
            
            $messages = array();
            foreach($customer_new_messages as $message){
                $messages[] = $message->id;
            }
            
            $this->data['customer_new_messages'] = Message::whereIn('id',$messages)->get();
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
        
        return User::whereIn('restaurant_id',$restaurant_array)->get();
    }

}

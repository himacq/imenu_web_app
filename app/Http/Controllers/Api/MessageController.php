<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

use App\Models\Message;
use App\Models\MessageReply;
use App\Models\Restaurant;

use App\Http\Resources\Message as MessageResource;
use App\Http\Resources\MessageCollection;

use DB;

class MessageController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * create message to restaurant
     * @param Request $request
     * @return type
     */
    public function send_message_restaurant(Request $request){
        $rules = [
            'restaurant_id' => 'required|integer',
            'title' => 'required',
            'message'=>'required'
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        /******/
        // create the record
        $restaurant = Restaurant::find($request->restaurant_id);
        if(!$restaurant)
            return $this->response(null, false,__('api.not_found'));
        
        $message = Message::create([
            'sender_id' => $this->user->id,
            'receiver_id' => $restaurant->owner_id,
            'message_type' => 2,
            'title' => $request->title,
            'message'=>$request->message,
            'isSeen' =>0
        ]);
        
        
        $messages = Message::where(['sender_id'=>$this->user->id])->get();
        $sent_messages = new MessageCollection($messages);
        
        return $sent_messages->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    
    /**
     * create message to system admin
     * @param Request $request
     * @return type
     */
    public function send_message_admin(Request $request){
        $rules = [
            'title' => 'required',
            'message'=>'required'
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        /******/
        // create the record

        $message = Message::create([
            'sender_id' => $this->user->id,
            'receiver_id' => 0,
            'message_type' => 1,
            'title' => $request->title,
            'message'=>$request->message,
            'isSeen' =>0
        ]);
        
        
        $messages = Message::where(['sender_id'=>$this->user->id])->get();
        $sent_messages = new MessageCollection($messages);
        
        return $sent_messages->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    /**
     * 
     * @return type
     */
    public function get_sent_messages(){
        $messages = Message::where(['sender_id'=>$this->user->id])->get();
        $sent_messages = new MessageCollection($messages);
        
        return $sent_messages->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    /**
     * 
     * @return type
     */
    public function inbox(){
        $messages = Message::where(['receiver_id'=>$this->user->id])->get();
        $sent_messages = new MessageCollection($messages);
        
        return $sent_messages->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    
    /**
     * 
     * @return type
     */
    public function unread(){
        $new_messages = DB::select('SELECT DISTINCT messages.id FROM messages '
                    . 'left outer join `message_replies` '
                    . 'on messages.id=message_replies.message_id '
                    . ' where ((messages.sender_id='.$this->user->id.' or messages.receiver_id='.$this->user->id.' )'
                    . 'and (message_replies.`sender_id` !='.$this->user->id.' '
                    . 'AND message_replies.`isSeen` = 0))  '
                    . 'or (messages.receiver_id='.$this->user->id.' and messages.isSeen=0)'
                    . '');
            
            $messages = array();
            foreach($new_messages as $new_message){
                $messages[] = $new_message->id;
            }
            
        $messages = Message::whereIn('id',$messages)->get();
            
        $messages = new MessageCollection($messages);
        
        return $messages->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    /**
     * 
     * @param type $id
     * @return type
     */
    public function details($id){
        $message = Message::find($id);
        
        if(!$message)
            return $this->response(null, false,__('api.not_found'));
        
        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id))
            return $this->response(null, false,__('api.not_found'));
        
        if($message->sender_id != $this->user->id)
            $message->update(['isSeen'=>1]);
        
        $latest = $message->replies->last();
        if($latest){
        if($latest->sender_id != $this->user->id){
            // it is a new message
             DB::table('message_replies')->where('message_id', '=', $id)->update(array('isSeen' => 1));
        }
        }
        
        $message_resource = new MessageResource($message);
        
        return $message_resource->additional(['status'=>true,'message'=>__('api.success')]);
    }
    
    public function reply(Request $request){
        $message = Message::find($request->message_id);
       
        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id))
            return $this->response(null, false,__('api.not_found'));
        
        $reply = MessageReply::create([
           'sender_id'=>$this->user->id,
            'message_id'=>$request->message_id,
            'message'=>$request->message,
            'isSeen'=>0
        ]);
        
      $message_resource = new MessageResource($message);
        
        return $message_resource->additional(['status'=>true,'message'=>__('api.success')]); 
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\MessageReply;

use DataTables;
use DB;

class MessageController extends Controller
{
    
     public function __construct()
    {
        $this->change_language();
        $this->middleware('auth');
        $this->data['menu'] = 'messages';
        $this->data['selected'] = 'create';
        $this->data['location'] = 'messages';
        $this->data['location_title'] = __('main.messages');

    }
    
    /**
     * 
     * @return type
     */
    public function inbox(){
        $this->data['sub_menu'] = 'inbox-messages';
         return view('message.inbox', $this->data);
    }
    
    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function inboxContentListData(Request $request)
    {
        $messages = Message::where(['receiver_id'=>$this->user->id])->orderBy('isSeen', 'asc') ->get();
       
          return DataTables::of($messages)
                  
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;
            })
            
            ->addColumn('title', function ($model) {
                return "<a href='".url("messages/details/$model->id")."' >".$model->title."</a>";
            })
             
            ->addColumn('sender', function ($model) {
                return $model->sender->name;
            })
            
            ->addColumn('replies', function ($model) {
                return $model->replies->count();
            })
            
            ->addColumn('control', function ($model) {
                $id = $model->id;
                
                $html='<a href="' . url("messages/details/" . $id ) . '"  class="btn dark btn-sm btn-outline sbold uppercase"><i class="fa fa-file-o"></i> '.__('main.view').' </a>';
                
                return $html;
            })
            ->rawColumns(['sender','control','replies','title'])
            ->make(true);

    }
    
    
    /**
     * 
     * @return type
     */
    public function sent(){
        $this->data['sub_menu'] = 'sent-messages';
         return view('message.sent', $this->data);
    }
    
    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function sentContentListData(Request $request)
    {
        $messages = Message::where(['sender_id'=>$this->user->id])->orderBy('isSeen', 'asc') ->get();
       
          return DataTables::of($messages)
                  
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;
            })
            
            ->addColumn('title', function ($model) {
                return "<a href='".url("messages/details/$model->id")."' >".$model->title."</a>";
            })
             
            ->addColumn('receiver', function ($model) {
                if($model->receiver)
                return $model->receiver->name;
                
                if($model->message_type==1)
                    return trans('messages.system_admin');
            })
            
            ->addColumn('replies', function ($model) {
                return $model->replies->count();
            })
            
            ->addColumn('control', function ($model) {
                $id = $model->id;
                
                $html='<a href="' . url("messages/details/" . $id ) . '"  class="btn dark btn-sm btn-outline sbold uppercase"><i class="fa fa-file-o"></i> '.__('main.view').' </a>';
                
                return $html;
            })
            ->rawColumns(['sender','control','replies','title'])
            ->make(true);

    }
    /**
     * 
     * @return type
     */
     public function customer_messages(){
         $this->data['sub_menu'] = 'customer_messages';
         return view('message.customer_messages', $this->data);
    }
    
    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function customerMessagesContentListData(Request $request)
    {
        $messages = Message::where(['message_type'=>1])->get();
       
          return DataTables::of($messages)
                  
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;
            })
            
            ->addColumn('title', function ($model) {
                return "<a href='".url("messages/details/$model->id")."' >".$model->title."</a>";
            })
             
            ->addColumn('sender', function ($model) {
                return $model->sender->name;
            })
            
            ->addColumn('replies', function ($model) {
                return $model->replies->count();
            })
            
            ->addColumn('control', function ($model) {
                $id = $model->id;
                
                $html='<a href="' . url("messages/details/" . $id ) . '"  class="btn dark btn-sm btn-outline sbold uppercase"><i class="fa fa-file-o"></i> '.__('main.view').' </a>';
                
                return $html;
            })
            ->rawColumns(['sender','control','replies','title'])
            ->make(true);

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['sub_menu'] = 'create-message';
        return view('message.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->message_type == 2){
            $restaurants = Restaurant::where(['isActive'=>1])->get();
            foreach($restaurants as $restaurant){
                if($restaurant->owner_id)
                $message = Message::create([
                    'message_type' => $request->message_type,
                    'sender_id' => $this->user->id,
                    'receiver_id' => $restaurant->owner_id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'isSeen'=>0
                ]);
               
            }
        }
        else if($request->message_type == 3){
            $users = User::where(['isActive'=>1])->get();
            foreach($users as $user){
                $message = Message::create([
                    'message_type' => $request->message_type,
                    'sender_id' => $this->user->id,
                    'receiver_id' => $user->id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'isSeen'=>0
                ]);
               
            }
        }
        
        else{
                $message = Message::create([
                    'message_type' => 1,
                    'sender_id' => $this->user->id,
                    'receiver_id' => 0,
                    'title' => $request->title,
                    'message' => $request->message,
                    'isSeen'=>0
                ]);
               
            
        }
        
        return redirect()->route('messages.sent')->with('status',trans('main.success'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        $message = Message::find($id);
        
        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id
                || $this->user->hasRole('superadmin')))
            return redirect()->route('messages.sent')->with('status', trans('main.not_found'));
        
        if($message->sender_id != $this->user->id)
            $message->update(['isSeen'=>1]);
        
        $latest = $message->replies->last();
        if($latest){
        if($latest->sender_id != $this->user->id){
            // it is a new message
             DB::table('message_replies')->where('message_id', '=', $id)->update(array('isSeen' => 1));
        }
        }
        
        /** fix number messages in top bar **/
        /************************************************/
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
            
            
         /************************************************************/   
            
        
        $this->data['message'] = $message;
        
        return view('message.details',$this->data);
        
    }
    
    public function store_reply(Request $request,$id){
        $message = Message::find($id);
       
        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id 
                || $this->user->hasRole('superadmin')))
            return redirect()->route('messages.sent')->with('status', trans('main.not_found'));
        
        $reply = MessageReply::create([
           'sender_id'=>$this->user->id,
            'message_id'=>$id,
            'message'=>$request->message,
            'isSeen'=>0
        ]);
        
      return redirect()->route('details',$id)->with('status',trans('main.success'));
        
        
    }

    
}

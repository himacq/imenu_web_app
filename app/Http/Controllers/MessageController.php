<?php

namespace App\Http\Controllers;

use App\Models\CustomerMessage;
use App\Models\CustomerMessageReply;
use Illuminate\Http\Request;

use App\Models\UserMessage;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\UserMessageReply;

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
        $messages = UserMessage::where(['receiver_id'=>$this->user->id])->orderBy('isSeen', 'asc') ->get();

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
        $this->data['menu'] = 'support';
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
        $messages = UserMessage::where(['sender_id'=>$this->user->id])->orderBy('isSeen', 'asc') ->get();

          return DataTables::of($messages)

            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;
            })

            ->addColumn('title', function ($model) {
                return "<a href='".url("messages/user_message_details/$model->id")."' >".$model->title."</a>";
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

                $html='<a href="' . url("messages/user_message_details/" . $id ) . '"  class="btn dark btn-sm btn-outline sbold uppercase"><i class="fa fa-file-o"></i> '.__('main.view').' </a>';

                return $html;
            })
            ->rawColumns(['sender','control','replies','title'])
            ->make(true);

    }
    /**
     *
     * @return type
     */
    public function users_messages(){
        $this->data['menu'] = 'support';
        $this->data['sub_menu'] = 'users_messages';
        return view('message.users_messages', $this->data);
    }

    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function userMessagesContentListData(Request $request)
    {
        $messages = UserMessage::where(['message_type'=>1])->get();

        return DataTables::of($messages)

            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;
            })

            ->addColumn('title', function ($model) {
                return "<a href='".url("messages/user_message_details/$model->id")."' >".$model->title."</a>";
            })

            ->addColumn('sender', function ($model) {
                return $model->sender->name;
            })

            ->addColumn('replies', function ($model) {
                return $model->replies->count();
            })

            ->addColumn('control', function ($model) {
                $id = $model->id;

                $html='<a href="' . url("messages/user_message_details/" . $id ) . '"  class="btn dark btn-sm btn-outline sbold uppercase"><i class="fa fa-file-o"></i> '.__('main.view').' </a>';

                return $html;
            })
            ->rawColumns(['sender','control','replies','title'])
            ->make(true);

    }

    /**
     *
     * @return type
     */
    public function customers_messages(){
        $this->data['menu'] = 'support';
        $this->data['sub_menu'] = 'customers_messages';
        return view('message.customers_messages', $this->data);
    }

    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function customerMessagesContentListData(Request $request)
    {

        if($this->user->hasRole('admin'))
            $messages = CustomerMessage::where(['message_type'=>2,'receiver_id'=>$this->user->id])->get();
        elseif($this->user->hasRole(['superadmin','c','c2']))
            $messages = CustomerMessage::where(['message_type'=>1])->get();

        return DataTables::of($messages)

            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;
            })

            ->addColumn('title', function ($model) {
                return "<a href='".url("messages/customer_message_details/$model->id")."' >".$model->title."</a>";
            })

            ->addColumn('sender', function ($model) {
                return $model->sender->name;
            })

            ->addColumn('replies', function ($model) {
                return $model->replies->count();
            })

            ->addColumn('control', function ($model) {
                $id = $model->id;

                $html='<a href="' . url("messages/customer_message_details/" . $id ) . '"  class="btn dark btn-sm btn-outline sbold uppercase"><i class="fa fa-file-o"></i> '.__('main.view').' </a>';

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
        $this->data['menu'] = 'support';
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
                $message = UserMessage::create([
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
                $message = UserMessage::create([
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
                $message = UserMessage::create([
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

    private function _fix_counter(){
        /**
         * count user's new messages
         */
        $new_messages = DB::select('SELECT DISTINCT user_messages.id FROM user_messages '
            . 'left outer join `user_message_replies` '
            . 'on user_messages.id=user_message_replies.message_id '
            . ' where ((user_messages.sender_id='.$this->user->id.' or user_messages.receiver_id='.$this->user->id.' )'
            . 'and (user_message_replies.`sender_id` !='.$this->user->id.' '
            . 'AND user_message_replies.`isSeen` = 0))  '
            . 'or (user_messages.receiver_id='.$this->user->id.' and user_messages.isSeen=0)'
            . '');



        $messages = array();
        foreach($new_messages as $message){
            $messages[] = $message->id;
        }

        $this->data['new_messages'] = UserMessage::whereIn('id',$messages)->get();
        /**
         * user's new messages
         */
        if($this->user->hasRole(['superadmin','c'])){
            $customer_new_messages = DB::select('SELECT DISTINCT customer_messages.id FROM customer_messages '
                . 'left outer join `customer_message_replies` '
                . 'on customer_messages.id=customer_message_replies.message_id '
                . ' where ((customer_messages.message_type=1 )'
                . 'and (customer_message_replies.`sender_id` !='.$this->user->id.' '
                . 'AND customer_message_replies.`isSeen` = 0))  '
                . 'or (customer_messages.message_type=1 and customer_messages.isSeen=0)'
                . '');


            $messages = array();
            foreach($customer_new_messages as $message){
                $messages[] = $message->id;
            }

            $this->data['customer_new_messages'] = CustomerMessage::whereIn('id',$messages)->get();
        }

        if($this->user->hasRole(['admin'])){
            $customer_new_messages = DB::select('SELECT DISTINCT customer_messages.id FROM customer_messages '
                . 'left outer join `customer_message_replies` '
                . 'on customer_messages.id=customer_message_replies.message_id '
                . ' where ((customer_messages.message_type=2 and customer_messages.receiver_id='.$this->user->id.' )'
                . 'and (customer_message_replies.`sender_id` !='.$this->user->id.' '
                . 'AND customer_message_replies.`isSeen` = 0))  '
                . 'or (customer_messages.message_type=2 and customer_messages.receiver_id='.$this->user->id.' and customer_messages.isSeen=0)'
                . '');


            $messages = array();
            foreach($customer_new_messages as $message){
                $messages[] = $message->id;
            }

            $this->data['customer_new_messages'] = CustomerMessage::whereIn('id',$messages)->get();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_message_details($id)
    {
        $this->data['menu'] = 'support';
        $message = UserMessage::find($id);

        if(!$message)
            return redirect()->route('users_messages')->with('status', trans('main.not_found'));

        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id
            || $this->user->hasRole(['superadmin','c','c1'])))
            return redirect()->route('users_messages')->with('status', trans('main.not_found'));


        $this->data['message'] = $message;

        return view('message.user_message_details',$this->data);

    }

    public function user_message_store_reply(Request $request,$id){
        $message = UserMessage::find($id);

        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id
            || $this->user->hasRole(['superadmin','c','c1'])))
            return redirect()->route('messages.sent')->with('status', trans('main.not_found'));

        $reply = UserMessageReply::create([
            'sender_id'=>$this->user->id,
            'message_id'=>$id,
            'message'=>$request->message,
            'isSeen'=>0
        ]);

        return redirect()->route('user_message_details',$id)->with('status',trans('main.success'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customer_message_details($id)
    {
        $this->data['menu'] = 'support';
        $message = CustomerMessage::find($id);

        if(!$message)
            return redirect()->route('customers_messages')->with('status', trans('main.not_found'));

        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id
            || $this->user->hasRole(['superadmin','c','admin','c2'])))
            return redirect()->route('customers_messages')->with('status', trans('main.not_found'));


        $this->data['message'] = $message;

        return view('message.customer_message_details',$this->data);

    }

    public function customer_message_store_reply(Request $request,$id){
        $message = CustomerMessage::find($id);

        if(!($message->sender_id == $this->user->id || $message->receiver_id == $this->user->id
            || $this->user->hasRole(['superadmin','c','admin','c2'])))
            return redirect()->route('customers_messages')->with('status', trans('main.not_found'));

        $reply = CustomerMessageReply::create([
            'sender_id'=>$this->user->id,
            'message_id'=>$id,
            'message'=>$request->message,
            'isSeen'=>0
        ]);

        return redirect()->route('customer_message_details',$id)->with('status',trans('main.success'));


    }


}

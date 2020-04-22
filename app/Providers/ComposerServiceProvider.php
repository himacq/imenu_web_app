<?php


namespace App\Providers;

use App\Models\CustomerMessage;
use App\Models\OrderRestaurant;
use App\Models\UserMessage;
use Illuminate\Support\ServiceProvider;

use Auth;
use DB;


class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {



        // Using Closure based composers...
        view()->composer('*', function ($view) {

            $user = Auth::user();
            $customer_new_messages = null;
            $new_messages = null ;

            if(!$user)
                return;

            /**************************************************************
             * orders staff
             */

            $orders = OrderRestaurant::where(['restaurant_id'=>$user->restaurant_id])
                ->whereDoesntHave('status',function($query){
                    $query->whereIn('status',[
                        \Config::get('settings.payment_order_status'),
                        \Config::get('settings.progress_order_status'),
                        \Config::get('settings.complete_order_status'),
                        \Config::get('settings.cancled_order_status'),
                        \Config::get('settings.delivered_order_status'),
                        \Config::get('settings.rejected_order_status'),
                    ]);
                })->orderby('id','asc')->get();


            $view->with('new_orders', $orders);
            /***************************************************************************
             * message process staff
             */
            /**
             * change message seen status
             */
            if(\Route::getCurrentRoute()->getActionName() == "App\Http\Controllers\MessageController@customer_message_details")
            {
                $id = \Route::current()->parameters()['id'];
                $message = CustomerMessage::find($id);

                if($message->sender_id != $user->id)
                    $message->update(['isSeen'=>1]);

                $latest = $message->replies->last();
                if($latest){
                    if($latest->sender_id != $user->id){
                        // it is a new message
                        DB::table('customer_message_replies')->where('message_id', '=', $id)->update(array('isSeen' => 1));
                    }
                }
            }

            else if(\Route::getCurrentRoute()->getActionName() == "App\Http\Controllers\MessageController@user_message_details")
            {
                $id = \Route::current()->parameters()['id'];
                $message = UserMessage::find($id);

                if($message->sender_id != $user->id)
                    $message->update(['isSeen'=>1]);

                $latest = $message->replies->last();
                if($latest){
                    if($latest->sender_id != $user->id){
                        // it is a new message
                        DB::table('user_message_replies')->where('message_id', '=', $id)->update(array('isSeen' => 1));
                    }
                }
            }

            /**
             * count user's new messages
             */
            if($user->hasRole(['admin'])) {
                $new_messages = DB::select('SELECT DISTINCT user_messages.id FROM user_messages '
                    . 'left outer join `user_message_replies` '
                    . 'on user_messages.id=user_message_replies.message_id '
                    . ' where ((user_messages.sender_id=' . $user->id . ' or user_messages.receiver_id=' . $user->id . ' )'
                    . 'and (user_message_replies.`sender_id` !=' . $user->id . ' '
                    . 'AND user_message_replies.`isSeen` = 0))  '
                    . 'or (user_messages.receiver_id=' . $user->id . ' and user_messages.isSeen=0)'
                    . '');

                $messages = array();
                foreach($new_messages as $message){
                    $messages[] = $message->id;
                }

                $new_messages = UserMessage::whereIn('id',$messages)->get();
            }

            if($user->hasRole(['superadmin','c','c1','c2'])){
                $new_messages = DB::select('SELECT DISTINCT user_messages.id FROM user_messages '
                    . 'left outer join `user_message_replies` '
                    . 'on user_messages.id=user_message_replies.message_id '
                    . ' where (user_messages.message_type=1 and user_messages.isSeen=0) '
                    .' or ((user_messages.message_type=1 ) and '
                    .'(user_message_replies.`sender_id` !='.$user->id.' AND user_message_replies.`isSeen` = 0))');



                $messages = array();
                foreach($new_messages as $message){
                    $messages[] = $message->id;
                }

                $new_messages = UserMessage::whereIn('id',$messages)->get();
            }

            /**
             * customers's new messages
             */
            if($user->hasRole(['superadmin','c','c1','c2'])){
                $customer_new_messages = DB::select('SELECT DISTINCT customer_messages.id FROM customer_messages '
                    . 'left outer join `customer_message_replies` '
                    . 'on customer_messages.id=customer_message_replies.message_id '
                    . ' where ((customer_messages.message_type=1 )'
                    . 'and (customer_message_replies.`sender_id` !='.$user->id.' '
                    . 'AND customer_message_replies.`isSeen` = 0))  '
                    . 'or (customer_messages.message_type=1 and customer_messages.isSeen=0)'
                    . '');

                $messages = array();
                foreach($customer_new_messages as $message){
                    $messages[] = $message->id;
                }

                $customer_new_messages= CustomerMessage::whereIn('id',$messages)->get();

            }

            if($user->hasRole(['admin'])){
                $customer_new_messages = DB::select('SELECT DISTINCT customer_messages.id FROM customer_messages '
                    . 'left outer join `customer_message_replies` '
                    . 'on customer_messages.id=customer_message_replies.message_id '
                    . ' where ((customer_messages.message_type=2 and customer_messages.receiver_id='.$user->id.' )'
                    . 'and (customer_message_replies.`sender_id` !='.$user->id.' '
                    . 'AND customer_message_replies.`isSeen` = 0))  '
                    . 'or (customer_messages.message_type=2 and customer_messages.receiver_id='.$user->id.' and customer_messages.isSeen=0)'
                    . '');

                $messages = array();
                foreach($customer_new_messages as $message){
                    $messages[] = $message->id;
                }

                $customer_new_messages = CustomerMessage::whereIn('id',$messages)->get();

            }



            $view->with('customer_new_messages', $customer_new_messages);
            $view->with('new_messages', $new_messages);

        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

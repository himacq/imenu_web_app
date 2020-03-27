<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessagesApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function send_message_to_restaurant_test(){

        $this->withoutExceptionHandling();
        $this->user_authenticated();

        $restaurant = factory('App\Models\Restaurant')->create();

        $response = $this->post('api/messages/send_message_restaurant',
                [
                    'restaurant_id'=>$restaurant->id,
                    'title'=>'test message send',
                    'message'=>'Message Body'
                    ],
                ['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */
    public function send_message_to_app_admin_test(){

        $this->withoutExceptionHandling();
        $this->user_authenticated();

        $response = $this->post('api/messages/send_message_admin',
                [
                    'title'=>'test message send',
                    'message'=>'Message Body'
                    ],
                ['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */
    public function send_reply_test(){

        $this->withoutExceptionHandling();
        $this->user_authenticated();

        $message = factory('App\Models\CustomerMessage')->create();

        $response = $this->post('api/messages/reply',
                [
                    'message_id'=>$message->id,
                    'message'=>'Message Body'
                    ],
                ['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */
    public function get_sent_messages(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();

        factory('App\Models\UserMessage',10)->create();
        $response = $this->get('api/messages/sent',['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */
    public function get_message_details(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();

        $message = factory('App\Models\CustomerMessage')->create();
         factory('App\Models\CustomerMessageReply',10)->create();
        $response = $this->get('api/messages/details/'.$message->id,['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */
    public function get_received_messages(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();

        factory('App\Models\UserMessage',10)->create();
        $response = $this->get('api/messages/inbox',['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */
    public function get_unread_messages(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();

        factory('App\Models\UserMessage',10)->create();
        $response = $this->get('api/messages/unread',['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }
}

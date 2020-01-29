<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


use App\Models\UserAddress;
use App\Models\User;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
       
    /***********************************************************************************/
    
    /**
     * @test
     */
    public function user_registration()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->post('/api/user/register',['name'=>'hima','username'=>'himacq','email'=>'dd@gg.com',
            'password'=>'asdddf']);
        
        $this->assertCount(1,User::all());
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
    
    /**
     * @test_later
     */
    public function user_login(){
        $this->withoutExceptionHandling();
        
        $response = $this->json('POST', '/api/user/login',['username'=>'admin',
            'password'=>'a123456']);
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    public function user_profile_update(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        
        $response = $this->post('/api/user/update',['name'=>'Ali','username'=>'himacq','email'=>'dd@gg.com',
            'password'=>'asdddf'],['api_token'=>$this->user->api_token]);
        
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    /**
     * @test
     */
    public function user_location_update(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        
        $response = $this->post('/api/user/location',['latitude'=>'sdsdsd52366',
            'longitude'=>'sdsdsd025665']);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    public function user_password_update(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        
        $response = $this->post('/api/user/password',['old_password'=>'a123456','new_password'=>'annn',
            'password_confirm'=>'annn'],['api_token'=>$this->user->api_token]);
        

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    public function user_logout(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        $response = $this->post('/api/user/logout',[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    public function user_address_add(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        $response = $this->post('/api/user/address',['street'=>'kool','city'=>'Beringen',
            'house_no'=>462,'floor_no'=>1,'isDefault'=>1],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    
    public function user_address_delete(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        $address = UserAddress::create(['street'=>'kool','city'=>'Beringen',
            'house_no'=>462,'floor_no'=>1,'isDefault'=>1,'user_id'=>$this->user->id]);
        
        
        $response = $this->delete('/api/user/address/'.$address->id,[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    public function user_addresses_list(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        
        $response = $this->get('/api/user/addresses',['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    
    public function user_address_update(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();
        
        $address = UserAddress::create(['street'=>'kool1','city'=>'Beringen1',
            'house_no'=>462,'floor_no'=>1,'isDefault'=>1,'user_id'=>$this->user->id]);
        
        $response = $this->post('/api/user/updateAddress',['street'=>'kool2','city'=>'Beringen2',
            'house_no'=>462,'floor_no'=>1,'isDefault'=>1,'id'=>$address->id],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    /**
     * @test
     */
    
    public function user_profile_get(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
        
        $response = $this->get('/api/user/profile',[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    
    
}

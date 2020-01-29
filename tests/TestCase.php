<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    
     protected $user = null;
    
    
    public function user_authenticated()
    {

        $this->user = User::create(['name'=>'hima','username'=>'admin','email'=>'dd@gg.com',
            'password'=>bcrypt('a123456'),'language_id'=>'en']);
  
        $this->user->generateToken();
        
        $response = $this->json('POST', '/api/user/login',['username'=>'admin',
            'password'=>'a123456']);
        
        $this->actingAs($this->user,'api');

    }
}

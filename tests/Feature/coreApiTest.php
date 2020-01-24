<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class coreApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function user_registration()
    {
        $this->withoutExceptionHandling();
        
        $this->post('/api/user/register',['name'=>'hima','username'=>'himacq','email'=>'dd@ff.com',
            'password'=>'asdddf']);
        
        $this->assertCount(1,User::all());
        
    }
}

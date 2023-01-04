<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
class SecuritySectionTest extends TestCase
{
    
   
    /** @test */
    public function can_show_security_section(){

        \Session::start();
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $response = $this->get('/security/personal');
        $response->assertStatus(200);
    
    }


    
}

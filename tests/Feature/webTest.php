<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // er class

class WebTest extends TestCase
{
    use RefreshDatabase; // shDatabase trait

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Spaces()
    {
        //test spaces

        $response = $this->get('/spaces');

        $response->assertStatus(200);
    }
    public function test_Dashboard()
    {
        //test dashboard

        $user = User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->get(route('dashboard.show'));
    
        
        $response->assertStatus(200);
    }
    public function testSettings()
    {
        //test tenant settings
       
        $user = User::factory()->create();
        $this->actingAs($user);

      
        $response = $this->get('/tenant/settings');

       
        $response->assertStatus(200);
    }
    public function TestCustomers(){
        
        //test tenant customers

        $user = User::factory()->create();
        $this->actingAs($user);

       
        $response = $this->get('/tenant/customers');

        
        $response->assertStatus(200);
    }
    public function TestProducts(){
        
        //test tenant products

        $user = User::factory()->create();
        $this->actingAs($user);

        
        $response = $this->get('/tenant/products');

        
        $response->assertStatus(200);
    }
    public function TestPayments(){
        
        //test tenant payments

        $user = User::factory()->create();
        $this->actingAs($user);

        
        $response = $this->get('/tenant/payments');

        
        $response->assertStatus(200);
    }
    public function TestUsers(){
        
        //test tenant users

        $user = User::factory()->create();
        $this->actingAs($user);

        
        $response = $this->get('/tenant/users');

        
        $response->assertStatus(200);
    }

}
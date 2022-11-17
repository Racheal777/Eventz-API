<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Favorite;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    //this function will run anytime the test is run to help  create the token for the user
    public function setUp():void{
        parent::setUp();
        Artisan::call('passport:install');
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_signup()
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->userName(),
            'password' => 'password',
            'password_confirmation' => 'password',
            
            
        ];


        $response = $this->json('POST',  route('users.register'), $payload);

        //dd($response);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => $payload['email']
        ]);

       
        $response
        ->assertStatus(200)
        ->assertJsonFragment([
            'email' => $payload['email']
        ]);

    }


    //test to login
    public function test_login_a_user()
    {
        //create the user
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->actingAs($user);
        $response = $this->json('POST',  route('users.login'), $payload);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => $payload['email']
        ]);

       
        $response
        ->assertStatus(200)
        ->assertJsonFragment([
            'email' => $payload['email']
        ]);


    }

    //not working

    // public function test_display_a_user()
    // {
    //     //create the user
    //     $user = User::factory()->create();

    //     Event::factory()->create();
    //     Favorite::factory()->create([
    //         "user_id" => $user->id
    //     ]);


    //     $this->actingAs($user);
    //     $response = $this->json('GET',  route('user'));

    //     //$this->assertDatabaseCount('users', 1);
        

       
    //     $response
    //     ->assertStatus(200)
    //     ->assertJsonCount(1, 'data')
    //     ;


    // }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Spatie\Newsletter\Newsletter;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    // public function test_signs_a_user_to_newsletters()
    // {

    //     $payload = [
    //         "firstname" => "James",
    //         "lastname" => "Kuranchie",
    //         "email"=> "kuranchiejames@gmail.com"
    //     ];
        
    //     $response = $this->json('POST', route('newsletters.store'), $payload);
    //     $response->assertStatus(200);
    //     Newsletter::shouldReceive('post')
    //     ->once()
    //     ->with($payload)
    //     ->andReturn([]);

    //     //$this->assertDatabaseCount('subscribers', 1);
    //     // $this->assertDatabaseHas('subscribers', [
    //     //     'email' => $payload['email']
    //     // ]);
       
    //     // ->assertJsonFragment([
    //     //     'email' => $payload['email']
    //     // ]);
        
    // }



    public function test_checks_if_a_user_has_subcribed_already()
    {
        $payload = [
            "firstname" => "Alhassan",
            "lastname" => "Yakubu",
            "email"=> "alhassan@walulel.com"
        ];


        $response = $this->json('POST', route('newsletters.store'), $payload);

        $this->assertDatabaseCount('subscribers', 0);
        

       
        $response
        ->assertStatus(401)
        ->assertJson([
           'message' => "user already subscribed",
        ]);
        
        
    }
}

<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Organizer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    

    //test to create an event
    public function test_creates_an_event()
    {
        //create the user
        $user = User::factory()->create();
        //$organizer = Organizer::factory()->create();

        Passport::actingAs($user);
       // $agent = $user->role;

      

        //check if the user is an admin

        //create the event
        $payload = [
            'name' => 'VGMA',
            'date' => date('Y/m/d'),
            'time' => '10:00 pm',
            'location' => 'Grand Arena',
            'category' => 'general',
            'flier' => fake()->image(),
            'organizer_id' => $user

        ];


        //response
        $response = $this->json('POST', route('events.store'), $payload);

        //dd($response);
        
        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', [
            'name'=> 'VGMA'
        ]);

        $response->assertStatus(201);
    }


    //get the data

    public function test_displays_all_events()
    {
         Event::factory(3)->create();

        $response = $this->json('GET', route('events.allEvents'));

        $this->assertDatabaseCount('events', 3);
        $response->assertStatus(200);
    }


    //delete a data
    public function test_deletes_an_event()
    {
        $organizer = Organizer::factory()->create();

        Passport::actingAs($organizer);

        $event = Event::factory()->create();
        $response = $this->json('DELETE', route('events.destroy', $event));

       // $this->assertDatabaseCount('events', 0);
        $response->assertStatus(200); 

    }


    //test to get todays events
    public function test_list_admins_events()
    {
        $organizer = Organizer::factory()->create();

        Passport::actingAs($organizer);

        Event::factory()->create();

        $response = $this->json('GET', route('admin'));

        $this->assertDatabaseCount('events', 1);
        $response->assertStatus(200);


    }
}

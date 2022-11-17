<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Favorite;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_adds_a_favorite()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $payload = [
            'event_id' => $event->id,
            'user_id' => $user->id
       ];
       
        Passport::actingAs($user);

        $response = $this->json('POST', route('favorite.store'), $payload);

        $this->assertDatabaseCount('favorites', 1);

        $response
        ->assertStatus(200);
       // ->assertJsonCount(5, 'data');
    }


    public function test_checks_if_event_has_been_added_to_users_favorite()
    {
        $user = User::factory()->create([
            "id" =>  2
        ]);
        $event = Event::factory()->create([
            "id" => 3
        ]);

        Favorite::factory()->create([
            'event_id' => $event->id,
            "user_id" => $user->id
           ]);


        $payload = [
            'event_id' => $event->id,
            'user_id' => $user->id
       ];

       
        Passport::actingAs($user);

        $response = $this->json('POST', route('favorite.store'), $payload);

        $this->assertDatabaseCount('favorites', 1);

        $response
        ->assertStatus(200)
        //->assertJsonCount(1, 'data')
        ->assertJson([
            'message' => "Event Already added to favorites",
         ]);;
       // ->assertJsonCount(5, 'data');
    }
}

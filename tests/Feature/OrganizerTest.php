<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrganizerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_an_organizer()

    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password',
            'image' => fake()->image(),
            'contact' => 0545203456,
            'description' => fake()->paragraph(),
            'location' => 'Adenta',
        ];

        $response = $this->json('POST', route('organizer.created'), $payload);

        $this->assertDatabaseCount('organizers', 1);
        $this->assertDatabaseHas('organizers', [
            'email' => $payload['email']
        ]);

       
        $response
        ->assertStatus(200)
        ->assertJsonFragment([
            'email' => $payload['email']
        ]);

       
    }
}

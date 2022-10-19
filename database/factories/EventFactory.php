<?php

namespace Database\Factories;

use App\Models\Organizer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
             'name' => fake()->title(),
            'date' => date('Y/m/d'),
            'time' => fake()->time(),
            'location' => 'Grand Arena',
            'category' => fake()->randomElement(['entertainment', 'religious', 'educational', 'general']),
            'flier' => fake()->image(),
            'organizer_id' =>User::factory()
        ];
    }
}

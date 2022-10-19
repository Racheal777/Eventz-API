<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organizer>
 */
class OrganizerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
          
            'image' => fake()->image(),
            'contact' => 0545203456,
            'description' => fake()->paragraph(),
            'location' => 'Adenta',
            'user_id' => User::factory()
           
        ];
    }
}

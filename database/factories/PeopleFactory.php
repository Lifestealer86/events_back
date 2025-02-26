<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PeopleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'date' => fake()->date(),
            'sex' => fake()->randomElement(['мужской', 'женский']),
            'user_id' => $user_id
        ];
    }
}

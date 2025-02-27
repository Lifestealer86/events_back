<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PeoplesFactory extends Factory
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
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'date' => fake()->date(),
            'sex' => fake()->randomElement(['мужской', 'женский']),
            'user_id' => $user_id
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventPlace>
 */
class EventPlaceFactory extends Factory
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
            'name' => $this->faker->company(),
            'city' => $this->faker->city(),
            'street' => $this->faker->streetName(),
            'house_number' => $this->faker->buildingNumber(),
            'office' => $this->faker->randomDigit(),
            'user_id' => $user_id
        ];
    }
}

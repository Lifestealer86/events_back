<?php

namespace Database\Factories;

use App\Models\EventPlace;
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
    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        $event_place_id = EventPlace::all()->random()->id;
        return [
            'name' => $this->faker->words(rand(3, 5), true),
            'event_counter' => rand(10, 50),
            'description' => $this->faker->text(),
            'img' => $this->randomImg(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
            'event_place_id' => $event_place_id,
            'user_id' => $user_id,
        ];
    }
    private function randomImg(): string {
        $imgArray = ['pic1.jpg',
            'pic2.png',
            'pic3.webp',
            'pic4.webp',
            'pic5.jpg'];
        return 'img/'.$imgArray[array_rand($imgArray)];
    }
}

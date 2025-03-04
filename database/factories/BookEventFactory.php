<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Peoples;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        $event_id = Event::all()->random()->id;
        $peoples_count = Peoples::all()->where('user_id', $user_id)->count();
        return [
            "user_id" => $user_id,
            "event_id" => $event_id,
            "people_count" => $peoples_count,
        ];
    }
}

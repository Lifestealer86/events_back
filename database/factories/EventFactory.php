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
            'name' => htmlspecialchars($this->randomTitle()),
            'event_counter' => rand(30, 50),
            'description' => $this->randomDescription(),
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
    private function randomTitle(): string {
        $imgArray = ['Конкурс "Сибирская природа"',
            'Фестиваль "Сибирские традиции"',
            'Конкурс "Сибирская лесозаготовка"',
            'Конкурс "Лучший гид по Сибири"',
            'Турнир "Сибирская рыбалка"',
            'Конкурс "Сибирская кухня"',
            'Конкурс "Покоряя высоту"'];
        return $imgArray[array_rand($imgArray)];
    }
    private function randomDescription(): string {
        $imgArray = ['Конкурс на лучшее фото сибирских пейзажей. Участники могут представить свои работы, запечатлевшие красоту природы Сибири.',
            'Фестиваль, посвященный культуре и традициям коренных народов Сибири. Участники могут продемонстрировать свои навыки в народных ремеслах и танцах.',
            'Конкурс для гидов, где они могут продемонстрировать свои знания о Сибири и навыки ведения экскурсий.',
            'Конкурс кулинаров, где участники представляют свои блюда, вдохновленные сибирскими традициями.',
            'Зимний фестиваль с различными активностями, включая катание на санях, лыжные гонки и конкурсы на лучшее снежное сооружение.',
            'Посмотрите как пилят деревья',
            'Узнайте совершенно обычные слова в сибирском колорите.'];
        return $imgArray[array_rand($imgArray)];
    }
}

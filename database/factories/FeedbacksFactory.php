<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FeedbacksFactory extends Factory
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
        return [
            "user_id" => $user_id,
            "event_id" => $event_id,
            "text" => $this->randomText(),
            "img_raiting" => $this->randomImg(),
            "raiting" => rand(1, 5),
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
    private function randomText(): string {
        $imgArray = ['Сибирь перевернула моё представление о России! Мы ночевали в зимовье у охотников, а утром нас будили крики журавлей. Это магия',
            'Спасибо за тур по Алтаю! Шаманский обряд у костра — это то, что останется в сердце навсегда',
            'Невероятные пейзажи и доброжелательные люди! Я в восторге от своего путешествия по Сибири!',
            'Сибирь — это не только природа, но и богатая культура. Я узнал много нового о традициях коренных народов!',
            'Донатная помойка!',
            'Самые крутое мероприятие ever!!!'];
        return $imgArray[array_rand($imgArray)];
    }
}

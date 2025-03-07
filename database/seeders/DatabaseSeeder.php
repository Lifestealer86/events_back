<?php

namespace Database\Seeders;

use App\Models\Feedbacks;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'first_name' => 'Иван',
             'last_name' => 'Иванов',
             'email' => 'user1@siberia.ru',
             'password' => Hash::make('user1P@ssword'),
             'birth_date' => '1990-01-01',
             'sex' => 'Мужской',
             'photo' => 'img/default.webp',
         ]);
         \App\Models\User::factory()->create([
             'first_name' => 'Ирина',
             'last_name' => 'Сидорова',
             'email' => 'user2@siberia.ru',
             'password' => Hash::make('user2P@ssword'),
             'birth_date' => '1993-02-11',
             'sex' => 'Женский',
             'photo' => 'img/default.webp',
         ]);

         \App\Models\Peoples::factory(7)->create();
         \App\Models\EventPlace::factory(10)->create();
         \App\Models\Event::factory(15)->create();
         \App\Models\Feedbacks::factory(10)->create();
         \App\Models\BookEvent::factory(10)->create();
    }
}

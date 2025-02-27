<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

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

         \App\Models\Peoples::factory(5)->create();
    }
}

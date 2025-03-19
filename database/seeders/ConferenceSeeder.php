<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conference;
use Faker\Factory as Faker;

class ConferenceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            Conference::create([
                'title' => $faker->sentence(3),
                'organizer' => $faker->company,
                'description' => $faker->paragraph(),
                'start_date' => $faker->dateTimeBetween('now', '+1 month'),
                'end_date' => $faker->dateTimeBetween('+1 month', '+2 months'),
                'status' => 'active',
            ]);
        }
    }
}

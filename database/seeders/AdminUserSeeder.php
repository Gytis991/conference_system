<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $roleOptions = [
            'admin',
            'client',
            'admin,client',
        ];

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'roles' => $faker->randomElement($roleOptions),
                'password' => Hash::make('password123'),
            ]);
        }
    }
}

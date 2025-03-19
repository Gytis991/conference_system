<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conference;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conference>
 */
class ConferenceFactory extends Factory
{
    protected $model = Conference::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(4),
            'organizer'   => $this->faker->company,
            'description' => $this->faker->paragraph,
            'start_date'  => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date'    => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'status'      => 'active',
        ];
    }
}

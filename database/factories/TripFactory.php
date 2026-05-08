<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        $destinations = [
            'Bokrijk',
            'Technopolis',
            'Pairi Daiza',
            'Zoo Antwerpen',
            'Planckendael',
            'Sint-Michielscollege',
            'Museum voor Natuurwetenschappen',
            'Provinciaal Domein',
        ];

        return [
            'name' => 'Uitstap naar ' . fake()->randomElement($destinations),
            'destination' => fake()->randomElement($destinations),
            'date' => fake()->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
            'price' => fake()->randomFloat(2, 5, 50),
        ];
    }
}

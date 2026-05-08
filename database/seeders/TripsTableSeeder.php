<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3 upcoming trips with fixed data
        $bokrijk = Trip::create([
            'name' => 'Bokrijk — Openluchtmuseum',
            'destination' => 'Bokrijk',
            'date' => now()->addWeeks(3)->format('Y-m-d'),
            'price' => 15.00,
        ]);

        $technopolis = Trip::create([
            'name' => 'Technopolis — Wetenschapsdag',
            'destination' => 'Technopolis',
            'date' => now()->addWeeks(5)->format('Y-m-d'),
            'price' => 22.50,
        ]);

        $pairiDaiza = Trip::create([
            'name' => 'Pairi Daiza — Dierentuin',
            'destination' => 'Pairi Daiza',
            'date' => now()->addWeeks(8)->format('Y-m-d'),
            'price' => 28.00,
        ]);

        // Create 15 extra dummy trips
        for ($i = 0; $i < 15; $i++) {
            Trip::create([
                // Example: "Schooltrip 1 — Educational Visit"
                'name' => 'Schooltrip ' . ($i + 1) . ' — ' . fake()->sentence(2),
                'destination' => fake()->city(),                       // Random city name
                'date' => fake()->dateTimeBetween('+1 week', '+6 months')->format('Y-m-d'),
                'price' => fake()->randomFloat(2, 10, 40),             // Price between 10 and 40
            ]);
        }

        // Attach students to the 3 main trips with random permission/paid values
        $students = Student::all();

        foreach ($students as $student) {
            // Bokrijk: classes 3A and 3B
            if (in_array($student->class, ['3A', '3B'])) {
                $bokrijk->students()->attach($student->id, [
                    'permission_given' => fake()->boolean(70),
                    'paid' => fake()->boolean(50),
                    'notes' => fake()->optional(0.2)->sentence(3),
                ]);
            }

            // Technopolis: classes 3A, 3B, 4A, 4B
            if (in_array($student->class, ['3A', '3B', '4A', '4B'])) {
                $technopolis->students()->attach($student->id, [
                    'permission_given' => fake()->boolean(60),
                    'paid' => fake()->boolean(40),
                    'notes' => fake()->optional(0.3)->sentence(3),
                ]);
            }

            // Pairi Daiza: classes 4A and 4B
            if (in_array($student->class, ['4A', '4B'])) {
                $pairiDaiza->students()->attach($student->id, [
                    'permission_given' => fake()->boolean(80),
                    'paid' => fake()->boolean(60),
                    'notes' => fake()->optional(0.15)->sentence(3),
                ]);
            }
        }
    }
}

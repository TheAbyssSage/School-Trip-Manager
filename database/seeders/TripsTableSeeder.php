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
            'description' => 'We bezoeken het openluchtmuseum in Bokrijk. Leerlingen ontdekken hoe mensen vroeger leefden in Vlaanderen. We vertrekken om 8:30 aan de schoolpoort en zijn terug rond 16:00.',
            'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Bokrijk + naam leerling\nGelieve te betalen voor 1 juni 2026.",
        ]);

        $technopolis = Trip::create([
            'name' => 'Technopolis — Wetenschapsdag',
            'destination' => 'Technopolis',
            'date' => now()->addWeeks(5)->format('Y-m-d'),
            'price' => 22.50,
            'description' => 'Een hele dag wetenschap en technologie in Technopolis Mechelen! Leerlingen doen hands-on experimenten en workshops. Lunchpakket zelf meebrengen.',
            'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Technopolis + naam leerling\nGelieve te betalen voor 15 juni 2026.",
        ]);

        $pairiDaiza = Trip::create([
            'name' => 'Pairi Daiza — Dierentuin',
            'destination' => 'Pairi Daiza',
            'date' => now()->addWeeks(8)->format('Y-m-d'),
            'price' => 28.00,
            'description' => 'Bezoek aan Pairi Daiza, een van de mooiste dierentuinen van Europa. We vertrekken vroeg (7:00) en zijn terug rond 18:00. Lunchpakket en drank zelf meebrengen.',
            'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Pairi Daiza + naam leerling\nGelieve te betalen voor 1 juli 2026.",
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

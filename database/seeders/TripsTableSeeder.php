<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripsTableSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [
            [
                'name' => 'Bokrijk — Openluchtmuseum',
                'destination' => 'Bokrijk',
                'date' => now()->addWeeks(3)->format('Y-m-d'),
                'price' => 15.00,
                'description' => 'We bezoeken het openluchtmuseum in Bokrijk. Leerlingen ontdekken hoe mensen vroeger leefden in Vlaanderen. We vertrekken om 8:30 aan de schoolpoort en zijn terug rond 16:00.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Bokrijk + naam leerling\nGelieve te betalen voor 1 juni 2026.",
                'classes' => ['3A', '3B'],
            ],
            [
                'name' => 'Technopolis — Wetenschapsdag',
                'destination' => 'Technopolis',
                'date' => now()->addWeeks(5)->format('Y-m-d'),
                'price' => 22.50,
                'description' => 'Een hele dag wetenschap en technologie in Technopolis Mechelen! Leerlingen doen hands-on experimenten en workshops. Lunchpakket zelf meebrengen.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Technopolis + naam leerling\nGelieve te betalen voor 15 juni 2026.",
                'classes' => ['3A', '3B', '4A', '4B'],
            ],
            [
                'name' => 'Pairi Daiza — Dierentuin',
                'destination' => 'Pairi Daiza',
                'date' => now()->addWeeks(8)->format('Y-m-d'),
                'price' => 28.00,
                'description' => 'Bezoek aan Pairi Daiza, een van de mooiste dierentuinen van Europa. We vertrekken vroeg (7:00) en zijn terug rond 18:00. Lunchpakket en drank zelf meebrengen.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Pairi Daiza + naam leerling\nGelieve te betalen voor 1 juli 2026.",
                'classes' => ['4A', '4B'],
            ],
            [
                'name' => 'Sportdag — Zwembad',
                'destination' => 'Zwembad Genk',
                'date' => now()->addWeeks(2)->format('Y-m-d'),
                'price' => 8.00,
                'description' => 'Sportdag in het zwembad van Genk. Zwemgerief en handdoek meebrengen. Er is een apart kleedkamer voor jongens en meisjes.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Sportdag + naam leerling\nGelieve te betalen voor 20 mei 2026.",
                'classes' => ['3A', '3B', '4A', '4B', '5A', '5B'],
            ],
            [
                'name' => 'Brussel — Museumbezoek',
                'destination' => 'Museum voor Natuurwetenschappen',
                'date' => now()->addWeeks(6)->format('Y-m-d'),
                'price' => 12.00,
                'description' => 'Bezoek aan het Museum voor Natuurwetenschappen in Brussel. Leerlingen ontdekken dinosaurussen, mineralen en de evolutie van de mens. Vertrek om 8:00, terug rond 17:00.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Brussel Museum + naam leerling\nGelieve te betalen voor 20 juni 2026.",
                'classes' => ['5A', '5B'],
            ],
            [
                'name' => 'Antwerpen — Havenrondvaart',
                'destination' => 'Haven van Antwerpen',
                'date' => now()->addWeeks(10)->format('Y-m-d'),
                'price' => 18.00,
                'description' => 'Rondvaart door de haven van Antwerpen, de op een na grootste haven van Europa. Leerlingen leren over import, export en de logistieke sector.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Haven Antwerpen + naam leerling\nGelieve te betalen voor 15 juli 2026.",
                'classes' => ['4A', '4B', '5A', '5B'],
            ],
            [
                'name' => 'Brugge — Historische Stadswandeling',
                'destination' => 'Brugge',
                'date' => now()->addWeeks(12)->format('Y-m-d'),
                'price' => 10.00,
                'description' => 'Wandeling door het historische centrum van Brugge (UNESCO Werelderfgoed). Bezoek aan het Belfort, de Markt en de reien. Stevige wandelschoenen aanbevolen.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Brugge + naam leerling\nGelieve te betalen voor 1 augustus 2026.",
                'classes' => ['3A', '3B'],
            ],
            [
                'name' => 'Kinderboerderij — Natuur & Dieren',
                'destination' => 'Kinderboerderij Kiewit',
                'date' => now()->addWeeks(4)->format('Y-m-d'),
                'price' => 5.00,
                'description' => 'Bezoek aan de kinderboerderij in Kiewit. Leerlingen leren over boerderijdieren, voeding en duurzaamheid. Laarzen of stevige schoenen aanbevolen.',
                'bank_details' => "Rekening: BE68 1234 5678 9012\nMededeling: Kinderboerderij + naam leerling\nGelieve te betalen voor 5 juni 2026.",
                'classes' => ['3A', '3B'],
            ],
        ];

        $allStudents = Student::all();

        foreach ($trips as $tripData) {
            $classes = $tripData['classes'];
            unset($tripData['classes']);

            $trip = Trip::create($tripData);

            // Attach students from matching classes
            $matchingStudents = $allStudents->filter(fn($s) => in_array($s->class, $classes));

            foreach ($matchingStudents as $student) {
                $trip->students()->attach($student->id, [
                    'permission_given' => fake()->boolean(65),
                    'paid' => fake()->boolean(45),
                    'notes' => fake()->optional(0.25)->randomElement([
                        'Allergie voor noten',
                        'Lactose-intolerant',
                        'Glutenvrij dieet',
                        'Astma — inhalator aanwezig',
                        'Hooikoorts — medicatie meegeven',
                        'Geen varkensvlees',
                        'Vegetarisch',
                        'Diabetes type 1 — suiker controleren',
                        'Reisziekte — pilletje voor vertrek',
                        'Epilepsie — noodmedicatie in boekentas',
                        null,
                    ]),
                ]);
            }
        }
    }
}

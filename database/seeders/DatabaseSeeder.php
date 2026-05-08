<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create teacher accounts
        User::factory()->teacher()->create([
            'name' => 'Mevrouw De Smet',
            'email' => 'teacher@school.be',
            'password' => bcrypt('password'),
        ]);

        User::factory()->teacher()->create([
            'name' => 'Meneer Van Damme',
            'email' => 'teacher2@school.be',
            'password' => bcrypt('password'),
        ]);

        // Create parent accounts
        $parentNames = [
            'Peeters', 'Janssens', 'Mertens', 'Willems', 'Claes',
            'Goossens', 'Wouters', 'De Smet', 'Dubois', 'Lambert',
            'Dupont', 'Hermans', 'Maes', 'Pauwels', 'Renard',
            'Segers', 'Timmermans', 'Vandenberghe', 'Verbeke', 'De Smedt',
            'Van Damme', 'Coppens', 'Seghers', 'De Cock', 'Bauwens',
            'Michiels', 'De Backer', 'Naessens', 'De Ridder', 'Verstraete',
            'De Groote', 'De Vos', 'De Winter', 'De Pauw', 'Lemmens',
            'De Clercq', 'De Meyer', 'De Bruyn', 'De Sutter', 'De Jaeger',
        ];

        $parents = [];
        foreach ($parentNames as $i => $name) {
            $parents[] = User::factory()->parent()->create([
                'name' => 'Ouder ' . $name,
                'email' => 'parent' . ($i + 1) . '@school.be',
                'password' => bcrypt('password'),
            ]);
        }

        $this->call([
            StudentsTableSeeder::class,
            TripsTableSeeder::class,
        ]);

        // Randomly assign each student to a parent
        $allStudents = Student::all();
        $parentCount = count($parents);

        foreach ($allStudents as $student) {
            $student->update([
                'parent_id' => $parents[array_rand($parents)]->id,
            ]);
        }
    }
}

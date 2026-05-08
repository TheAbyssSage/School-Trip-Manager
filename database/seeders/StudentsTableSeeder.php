<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            // 3A
            ['name' => 'Emma Peeters', 'class' => '3A'],
            ['name' => 'Lucas Janssens', 'class' => '3A'],
            ['name' => 'Marie Mertens', 'class' => '3A'],
            ['name' => 'Thomas Willems', 'class' => '3A'],
            ['name' => 'Sara Claes', 'class' => '3A'],
            ['name' => 'Daan Verbeke', 'class' => '3A'],
            ['name' => 'Lotte De Smedt', 'class' => '3A'],
            // 3B
            ['name' => 'Noah Goossens', 'class' => '3B'],
            ['name' => 'Julie Wouters', 'class' => '3B'],
            ['name' => 'Liam De Smet', 'class' => '3B'],
            ['name' => 'Eline Dubois', 'class' => '3B'],
            ['name' => 'Arthur Lambert', 'class' => '3B'],
            ['name' => 'Fien Van Damme', 'class' => '3B'],
            ['name' => 'Milan Coppens', 'class' => '3B'],
            // 4A
            ['name' => 'Louise Dupont', 'class' => '4A'],
            ['name' => 'Victor Hermans', 'class' => '4A'],
            ['name' => 'Charlotte Maes', 'class' => '4A'],
            ['name' => 'Jules Pauwels', 'class' => '4A'],
            ['name' => 'Amber Seghers', 'class' => '4A'],
            ['name' => 'Robbe De Cock', 'class' => '4A'],
            ['name' => 'Nina Bauwens', 'class' => '4A'],
            // 4B
            ['name' => 'Alice Renard', 'class' => '4B'],
            ['name' => 'Louis Segers', 'class' => '4B'],
            ['name' => 'Manon Timmermans', 'class' => '4B'],
            ['name' => 'Hugo Vandenberghe', 'class' => '4B'],
            ['name' => 'Eva Michiels', 'class' => '4B'],
            ['name' => 'Wout De Backer', 'class' => '4B'],
            ['name' => 'Lore Naessens', 'class' => '4B'],
            // 5A
            ['name' => 'Jasper De Ridder', 'class' => '5A'],
            ['name' => 'Hanne Verstraete', 'class' => '5A'],
            ['name' => 'Simon De Groote', 'class' => '5A'],
            ['name' => 'Laura De Vos', 'class' => '5A'],
            ['name' => 'Brent De Winter', 'class' => '5A'],
            ['name' => 'Yana De Pauw', 'class' => '5A'],
            // 5B
            ['name' => 'Kobe Lemmens', 'class' => '5B'],
            ['name' => 'Lien De Clercq', 'class' => '5B'],
            ['name' => 'Arne De Meyer', 'class' => '5B'],
            ['name' => 'Sofie De Bruyn', 'class' => '5B'],
            ['name' => 'Jens De Sutter', 'class' => '5B'],
            ['name' => 'Elise De Jaeger', 'class' => '5B'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}

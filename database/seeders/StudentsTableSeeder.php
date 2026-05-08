<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create specific students across a few classes
        $students = [
            ['name' => 'Emma Peeters', 'class' => '3A'],
            ['name' => 'Lucas Janssens', 'class' => '3A'],
            ['name' => 'Marie Mertens', 'class' => '3A'],
            ['name' => 'Thomas Willems', 'class' => '3A'],
            ['name' => 'Sara Claes', 'class' => '3A'],
            ['name' => 'Noah Goossens', 'class' => '3B'],
            ['name' => 'Julie Wouters', 'class' => '3B'],
            ['name' => 'Liam De Smet', 'class' => '3B'],
            ['name' => 'Eline Dubois', 'class' => '3B'],
            ['name' => 'Arthur Lambert', 'class' => '3B'],
            ['name' => 'Louise Dupont', 'class' => '4A'],
            ['name' => 'Victor Hermans', 'class' => '4A'],
            ['name' => 'Charlotte Maes', 'class' => '4A'],
            ['name' => 'Jules Pauwels', 'class' => '4A'],
            ['name' => 'Alice Renard', 'class' => '4B'],
            ['name' => 'Louis Segers', 'class' => '4B'],
            ['name' => 'Manon Timmermans', 'class' => '4B'],
            ['name' => 'Hugo Vandenberghe', 'class' => '4B'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}

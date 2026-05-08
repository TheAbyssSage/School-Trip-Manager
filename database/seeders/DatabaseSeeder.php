<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create teacher account
        User::factory()->teacher()->create([
            'name' => 'Teacher',
            'email' => 'teacher@school.be',
            'password' => bcrypt('password'),
        ]);

        // Create parent accounts
        $parent1 = User::factory()->parent()->create([
            'name' => 'Parent Peeters',
            'email' => 'parent@school.be',
            'password' => bcrypt('password'),
        ]);

        $parent2 = User::factory()->parent()->create([
            'name' => 'Parent Janssens',
            'email' => 'parent2@school.be',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            StudentsTableSeeder::class,
            TripsTableSeeder::class,
        ]);

        // Link parents to students
        \App\Models\Student::whereIn('name', ['Emma Peeters', 'Lucas Janssens', 'Marie Mertens'])
            ->update(['parent_id' => $parent1->id]);

        \App\Models\Student::whereIn('name', ['Noah Goossens', 'Julie Wouters', 'Liam De Smet'])
            ->update(['parent_id' => $parent2->id]);
    }
}

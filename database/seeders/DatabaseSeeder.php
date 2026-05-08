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
        User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@school.be',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            StudentsTableSeeder::class,
            TripsTableSeeder::class,
        ]);
    }
}

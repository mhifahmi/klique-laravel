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
        // call each seeder
        $this->call([
            UserSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            RoomSeeder::class,
            QueueSeeder::class,
        ]);
    }
}

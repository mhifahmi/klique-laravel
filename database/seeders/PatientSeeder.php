<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('patients')->insert([
                'fullname' => fake('id_ID')->name(),
                'nik' => fake()->numerify('################'),
                'birthdate' => fake()->date('Y-m-d', '2000-01-01'),
                'phone_number' => fake('id_ID')->phoneNumber(),
                'gender' => fake()->randomElement(['M', 'F']),
                'address' => fake('id_ID')->address(),
                'note' => fake()->optional()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

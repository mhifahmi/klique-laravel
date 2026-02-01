<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('doctors')->insert([
                'fullname' => 'Dr. ' . fake('id_ID')->firstName . ' ' . fake('id_ID')->lastName,
                'nik' => fake()->numerify('################'),
                'sip_number' => fake()->randomNumber(5, true) . '/SIP/2025',
                'birthdate' => fake()->date('Y-m-d', '1985-01-01'),
                'phone_number' => fake()->phoneNumber,
                'gender' => fake()->randomElement(['M', 'F']),
                'address' => fake('id_ID')->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

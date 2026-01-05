<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Admin
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'role' => 'ADMIN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Akun Staff
        DB::table('users')->insert([
            'name' => 'Herta',
            'username' => 'staff',
            'password' => Hash::make('123456'),
            'role' => 'STAFF',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

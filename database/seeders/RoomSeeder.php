<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorIds = DB::table('doctors')->pluck('id')->toArray();

        $rooms = [
            ['room_name' => 'Poli Umum 1', 'status' => 'AVAILABLE'],
            ['room_name' => 'Poli Umum 2', 'status' => 'CONSULTATION']
        ];

        foreach ($rooms as $index => $room) {
            DB::table('rooms')->insert([
                'room_name' => $room['room_name'],
                'doctor_id' => $doctorIds[$index % count($doctorIds)] ?? null,
                'status' => $room['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

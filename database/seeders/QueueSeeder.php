<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patientIds = DB::table('patients')->pluck('id')->toArray();
        $roomIds = DB::table('rooms')->pluck('id')->toArray();
        $userId = DB::table('users')->value('id');

        // History data
        for ($i = 1; $i <= 10; $i++) {
            DB::table('queues')->insert([
                'queue_number' => 'A-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'date' => Carbon::yesterday()->format('Y-m-d'),
                'call_at' => Carbon::yesterday()->hour(8)->minute($i * 10),
                'finish_at' => Carbon::yesterday()->hour(8)->minute(($i * 10) + 15),
                'status' => 'COMPLETED',
                'patient_id' => $patientIds[array_rand($patientIds)],
                'room_id' => $roomIds[array_rand($roomIds)],
                'user_id' => $userId,
                'created_at' => Carbon::yesterday(),
                'updated_at' => Carbon::yesterday(),
                'note' => fake()->optional()->sentence(),
            ]);
        }

        // Present data
        $statuses = ['COMPLETED', 'SERVED', 'CALLED', 'WAITING', 'WAITING', 'WAITING'];

        foreach ($statuses as $index => $status) {
            $num = $index + 1;
            $queueNumber = 'A-' . str_pad($num, 3, '0', STR_PAD_LEFT);

            $callAt = ($status !== 'WAITING') ? Carbon::now() : null;
            $finishAt = ($status === 'COMPLETED') ? Carbon::now() : null;

            DB::table('queues')->insert([
                'queue_number' => $queueNumber,
                'date' => Carbon::now()->format('Y-m-d'),
                'call_at' => $callAt,
                'finish_at' => $finishAt,
                'status' => $status,
                'patient_id' => $patientIds[array_rand($patientIds)],
                'room_id' => $roomIds[array_rand($roomIds)], // Random room
                'user_id' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'note' => fake()->optional()->sentence(),
            ]);
        }
    }
}

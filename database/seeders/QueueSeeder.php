<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('queues')->truncate();

        $patientIds = DB::table('patients')->pluck('id')->toArray();
        $roomIds = DB::table('rooms')->pluck('id')->toArray();
        $userId = DB::table('users')->value('id');


        for ($i = 1; $i <= 10; $i++) {
            DB::table('queues')->insert([
                'queue_number' => 'A-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'date' => Carbon::yesterday()->format('Y-m-d'),
                'call_at' => Carbon::yesterday()->hour(8)->minute($i * 15),
                'finish_at' => Carbon::yesterday()->hour(8)->minute(($i * 15) + 10),
                'status' => 'COMPLETED',
                'patient_id' => $patientIds[array_rand($patientIds)],
                'room_id' => $roomIds[array_rand($roomIds)],
                'user_id' => $userId,
                'created_at' => Carbon::yesterday()->hour(7)->minute(rand(0, 59)),
                'updated_at' => Carbon::yesterday()->hour(17),
                'note' => fake()->optional()->sentence(),
            ]);
        }

        $totalToday = 50;
        $currentServedIndex = 15;

        for ($i = 1; $i <= $totalToday; $i++) {
            $queueNumber = 'A-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $status = 'WAITING';
            $callAt = null;
            $finishAt = null;

            $baseTime = Carbon::now()->startOfDay()->addHours(8);

            if ($i < $currentServedIndex) {
                $status = 'COMPLETED';
                $callAt = (clone $baseTime)->addMinutes(($i - 1) * 15);
                $finishAt = (clone $callAt)->addMinutes(12);
            } elseif ($i === $currentServedIndex) {
                $status = 'SERVED';
                $callAt = Carbon::now()->subMinutes(5);
                $finishAt = null;
            } elseif ($i === $currentServedIndex + 1) {
                $status = 'CALLED';
                $callAt = Carbon::now();
                $finishAt = null;
            } else {
                $status = 'WAITING';
                $callAt = null;
                $finishAt = null;
            }

            DB::table('queues')->insert([
                'queue_number' => $queueNumber,
                'date' => Carbon::now()->format('Y-m-d'),
                'call_at' => $callAt,
                'finish_at' => $finishAt,
                'status' => $status,
                'patient_id' => $patientIds[array_rand($patientIds)],
                'room_id' => $roomIds[array_rand($roomIds)],
                'user_id' => $userId,
                'created_at' => Carbon::now()->startOfDay()->addHours(7)->addMinutes(rand(0, $i * 5)),
                'updated_at' => Carbon::now(),
                'note' => fake()->optional()->sentence(),
            ]);
        }
    }
}

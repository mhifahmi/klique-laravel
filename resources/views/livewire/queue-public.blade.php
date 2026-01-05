<?php

use function Livewire\Volt\{layout, with};
use Carbon\Carbon;
use App\Models\Queue;
use App\Models\Room;

layout('components.layouts.public');

with(function () {
    Carbon::setLocale('id');
    $today = Carbon::today();

    // --- 1. AMBIL ANTRIAN YANG SEDANG DIPANGGIL (MAIN CARD) ---
    // Mencari antrian dengan status 'CALLED' hari ini, urutkan berdasarkan waktu panggil terbaru
    $activeQueue = Queue::with(['patient', 'room.doctor']) // Load relasi patient & room beserta doctor-nya
        ->whereDate('date', $today)
        ->where('status', 'CALLED')
        ->orderByDesc('call_at')
        ->first();

    // --- 2. AMBIL LIST RUANGAN & STATUSNYA ---
    $roomsData = Room::with('doctor')
        ->get()
        ->map(function ($room) use ($today) {
            // Cari antrian yang sedang aktif (CALLED/SERVED) di ruangan spesifik ini
            $queueInRoom = Queue::where('room_id', $room->id)
                ->whereDate('date', $today)
                ->whereIn('status', ['CALLED', 'SERVED']) // Status aktif pelayanan
                ->latest('updated_at')
                ->first();

            // Translate Status Room DB ke Bahasa Indonesia
            $statusLabel = match ($room->status) {
                'AVAILABLE' => 'Tersedia',
                'CONSULTATION' => 'Sedang Periksa',
                'BREAK' => 'Istirahat',
                default => '-',
            };

            // Tentukan warna status
            $statusColor = match ($room->status) {
                'AVAILABLE' => 'text-success',
                'CONSULTATION' => 'text-danger',
                'BREAK' => 'text-warning',
                default => 'text-secondary',
            };

            return [
                'name' => $room->room_name, // Sesuai DB: room_name
                'status_label' => $statusLabel,
                'status_color' => $statusColor,
                'doctor' => $room->doctor ? $room->doctor->fullname : '-', // Sesuai DB: fullname
                'current_number' => $queueInRoom ? $queueInRoom->queue_number : '-', // Sesuai DB: queue_number
            ];
        });

    // --- 3. STATISTIK ---
    $stats = [
        // Sesuai DB enum: WAITING, MISSED, COMPLETED
        'waiting' => Queue::whereDate('date', $today)->where('status', 'WAITING')->count(),
        'missed' => Queue::whereDate('date', $today)->where('status', 'MISSED')->count(),
        'completed' => Queue::whereDate('date', $today)->where('status', 'COMPLETED')->count(),
    ];

    return [
        'activeQueue' => $activeQueue,
        'rooms' => $roomsData,
        'stats' => $stats,
    ];
});
?>

<div wire:poll.3s>

    <div class="row mb-4 align-items-center">
        <div class="col-5">
            <h1 class="header-title">Antrian Klinik</h1>
        </div>

        <div class="col-7 text-end">
            <div x-data="{
                dateDisplay: '',
                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
                    const now = new Date();
                    // Format: Senin, 14 Desember 2025 14:30:05
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    };
                    this.dateDisplay = now.toLocaleDateString('id-ID', options).replace(/\./g, ':');
                }
            }" class="header-date">
                <span x-text="dateDisplay"></span>
            </div>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-md-7">
            <div class="queue-card d-flex flex-column text-center justify-content-between">
                <div>
                    <div class="card-header-strip">Panggilan Antrian</div>

                    @if ($activeQueue)
                        <div class="big-number">{{ $activeQueue->queue_number }}</div>
                        <div class="patient-name">{{ $activeQueue->patient->fullname ?? 'Pasien Umum' }}</div>
                    @else
                        <div class="big-number text-muted" style="font-size: 5rem; margin: 40px 0;">--</div>
                        <div class="patient-name">Silakan Tunggu</div>
                    @endif

                </div>

                <div class="card-footer-strip">
                    @if ($activeQueue && $activeQueue->room)
                        {{ $activeQueue->room->room_name }}
                        @if ($activeQueue->room->doctor)
                            - {{ $activeQueue->room->doctor->fullname }}
                        @endif
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-5">
            @foreach ($rooms as $room)
                <div class="room-item">
                    <div class="room-header">
                        <span>{{ $room['name'] }}</span>
                        <span class="{{ $room['status_color'] }} fw-bold">
                            | {{ $room['status_label'] }}
                        </span>
                    </div>
                    <div class="room-doctor d-flex justify-content-between align-items-center">
                        <span class="text-truncate" style="max-width: 70%;">{{ $room['doctor'] }}</span>

                        @if ($room['current_number'] !== '-')
                            <span class="badge bg-dark fs-5">{{ $room['current_number'] }}</span>
                        @else
                            <span class="text-muted small">--</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="stat-box">
                <div class="stat-title">Menunggu</div>
                <div class="stat-number">{{ $stats['waiting'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box">
                <div class="stat-title">Terlewat</div>
                <div class="stat-number">{{ $stats['missed'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box">
                <div class="stat-title">Selesai</div>
                <div class="stat-number">{{ $stats['completed'] }}</div>
            </div>
        </div>
    </div>
</div>

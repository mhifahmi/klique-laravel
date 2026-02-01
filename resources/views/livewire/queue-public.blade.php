<?php

use function Livewire\Volt\{layout, with};
use Carbon\Carbon;
use App\Models\Queue;
use App\Models\Room;

layout('components.layouts.public');

with(function () {
    Carbon::setLocale('id');
    $today = Carbon::today();

    $activeQueue = Queue::with(['patient', 'room.doctor']) // Load relasi patient & room beserta doctor-nya
        ->whereDate('date', $today)
        ->where('status', 'CALLED')
        ->orderByDesc('call_at')
        ->first();

    $roomsData = Room::with('doctor')
        ->get()
        ->map(function ($room) use ($today) {
            $queueInRoom = Queue::where('room_id', $room->id)
                ->whereDate('date', $today)
                ->whereIn('status', ['CALLED', 'SERVED'])
                ->latest('updated_at')
                ->first();

            $statusLabel = match ($room->status) {
                'AVAILABLE' => 'Tersedia',
                'CONSULTATION' => 'Sedang Periksa',
                'BREAK' => 'Istirahat',
                default => '-',
            };

            $statusColor = match ($room->status) {
                'AVAILABLE' => 'text-success',
                'CONSULTATION' => 'text-danger',
                'BREAK' => 'text-warning',
                default => 'text-secondary',
            };

            return [
                'name' => $room->room_name,
                'status_label' => $statusLabel,
                'status_color' => $statusColor,
                'doctor' => $room->doctor ? $room->doctor->fullname : '-',
                'current_number' => $queueInRoom ? $queueInRoom->queue_number : '-',
            ];
        });

    $stats = [
        'waiting' => Queue::whereDate('date', $today)->where('status', 'WAITING')->count(),
        'missed' => Queue::whereDate('date', $today)->where('status', 'MISSED')->count(),
        'completed' => Queue::whereDate('date', $today)->where('status', 'COMPLETED')->count(),
    ];

    $upcomingQueues = Queue::with(['room', 'patient'])
        ->whereDate('date', $today)
        ->where('status', 'WAITING')
        // ->orderBy('created_at', 'asc')
        ->orderBy('id', 'asc')
        ->take(6)
        ->get();

    return [
        'activeQueue' => $activeQueue,
        'rooms' => $roomsData,
        'stats' => $stats,
        'upcoming' => $upcomingQueues,
    ];
});
?>

<div wire:poll.3s class="container-fluid p-4 d-flex flex-column h-100">

    {{-- top section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-6">
            <h1 class="header-title">
                <img src="{{ asset('assets/logo.png') }}" height="50" class="me-2" style="opacity: 0.8;"
                    alt="logo">{{ config('klinik.name') }}
            </h1>
            <p class="text-muted mb-0 ms-1">{{ config('klinik.short_desc') }}</p>
        </div>
        {{-- time today --}}
        <div class="col-6 text-end">
            <div x-data="{
                dateDisplay: '',
                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
                    const now = new Date();
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
                    this.dateDisplay = now.toLocaleDateString('id-ID', options).replace(/\./g, ':');
                }
            }" class="header-date">
                <img src="{{ asset('icon/clock.svg') }}"alt="clock" width="32" height="32">

                <i class="bi bi-clock me-2 text-primary"></i>
                <span x-text="dateDisplay"></span>
            </div>
        </div>
    </div>

    {{-- content section --}}
    <div class="row flex-grow-1">
        {{-- left section --}}
        {{-- card list queues --}}
        <div class="col-xl-7 col-lg-7">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 24px; overflow: hidden;">
                <div class="card-header bg-white p-4 border-bottom-0">
                    <h4 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-list-ol me-2 text-primary"></i>
                        Antrian Selanjutnya
                    </h4>
                    <p class="text-muted small mb-0">Pasien berikut harap bersiap di ruang tunggu</p>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">No. Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Tujuan Poli/Ruang</th>
                                <th class="text-end pe-4">Est.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcoming as $queue)
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-primary bg-opacity-10 text-primary fs-5 px-3">
                                            {{ $queue->queue_number }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $queue->patient->fullname }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success p-1 me-2"
                                                style="width: 8px; height: 8px;"></div>
                                            <small class="text-muted fw-semibold">{{ $queue->room->room_name }}</small>
                                        </div>
                                        <small class="text-muted fst-italic" style="font-size: 0.75rem;">
                                            {{ $queue->room->doctor->fullname ?? '-' }}
                                        </small>
                                    </td>
                                    <td class="text-end pe-4 text-muted">
                                        <small>Menunggu</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <img src="{{ asset('assets/empty-state.png') }}" height="80"
                                            class="mb-3 opacity-50">
                                        <p>Tidak ada antrian menunggu</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- right section --}}
        <div class="col-xl-5 col-lg-5 d-flex flex-column gap-4">
            {{-- card called queue --}}
            <div class="main-call-card flex-grow-1" style="min-height: 300px;">
                <div class="call-status">Sedang Dipanggil</div>
                @if ($activeQueue)
                    <div class="call-number">{{ $activeQueue->queue_number }}</div>
                    <div class="call-patient">{{ $activeQueue->patient->fullname ?? 'Pasien Umum' }}</div>
                    <div class="call-room">
                        {{ $activeQueue->room->room_name }}
                    </div>
                @else
                    <div class="call-number text-muted" style="font-size: 5rem; opacity: 0.3;">--</div>
                @endif
            </div>
            {{-- card list room --}}
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body">
                    <h6 class="text-muted fw-bold mb-3 text-uppercase small">Status Dokter</h6>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($rooms as $room)
                            <div class="d-flex justify-content-between align-items-center p-2 rounded"
                                style="background-color: #f8f9fa;">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <div class="me-2 rounded-circle {{ $room['status_color'] == 'text-danger' ? 'bg-danger' : 'bg-success' }}"
                                        style="width: 10px; height: 10px;" title="{{ $room['status_label'] }}"></div>

                                    <div class="d-flex flex-column text-truncate">
                                        <span
                                            class="fw-bold text-dark small text-truncate">{{ $room['doctor'] }}</span>
                                        <span class="text-muted small text-truncate"
                                            style="font-size: 0.7rem;">{{ $room['name'] }}</span>
                                    </div>
                                </div>

                                @if ($room['current_number'] !== '-')
                                    <span
                                        class="badge bg-white text-dark border shadow-sm">{{ $room['current_number'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

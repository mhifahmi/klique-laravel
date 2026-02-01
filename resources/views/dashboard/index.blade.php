@extends('layouts.dashboard')

@section('title', 'Dashboard Operasional')

@section('content')

    {{-- Row 1: Statistik Pasien --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <x-dashboard.stat-card title="Jumlah Pasien Hari ini" value="{{ $stats['total'] }}" icon="bi-people-fill"
                color="primary" subTitle="Total Registrasi" />
        </div>

        <div class="col-md-4 mb-3">
            <x-dashboard.stat-card title="Pasien Dalam Antrian" value="{{ $stats['waiting'] }}" icon="bi-hourglass-split"
                color="warning" subTitle="Menunggu Dipanggil" />
        </div>

        <div class="col-md-4 mb-3">
            <x-dashboard.stat-card title="Pasien Selesai" value="{{ $stats['completed'] }}" icon="bi-check-circle-fill"
                color="success" subTitle="Selesai Diperiksa" />
        </div>
    </div>

    {{-- Row 2: Status Operasional --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <x-dashboard.stat-card title="Pasien Dilewati" value="{{ $stats['missed'] }}" icon="bi-slash-circle"
                color="danger" subTitle="Tidak Hadir / Skip" />
        </div>

        <div class="col-md-4 mb-3">
            <x-dashboard.stat-card title="Ketersediaan Ruangan" value="{{ $roomAvailability }}" icon="bi-door-open-fill"
                color="info" subTitle="Ruangan Aktif" />
        </div>

        <div class="col-md-4 mb-3">
            <div class="card bg-dark text-white shadow h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50">Sedang Dipanggil</h6>
                        <h2 class="fw-bold mb-0 display-6">{{ $currentNumber }}</h2>
                    </div>
                    <div class="fs-1 text-white-50">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 3: Grafik Statistik --}}
    {{-- <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart-line me-2"></i>Tren Kunjungan Pasien</h6>

                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>Minggu Ini</option>
                        <option>Bulan Ini</option>
                        <option>Tahun Ini</option>
                    </select>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center justify-content-center text-muted"
                        style="height: 300px; background-color: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px;">
                        @if ($stats['total'] > 0)
                            <i class="bi bi-graph-up fs-1 mb-3 text-primary"></i>
                            <p class="mb-0 fw-bold text-dark">Data Siap Ditampilkan</p>
                            <small>Menggunakan library Chart.js nanti</small>
                        @else
                            <i class="bi bi-graph-up fs-1 mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada data kunjungan hari ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

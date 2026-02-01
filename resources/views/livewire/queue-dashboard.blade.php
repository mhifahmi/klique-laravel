<div>
    {{-- Section 1: Kontrol Panggilan Utama --}}
    <div class="row mb-4">
        {{-- Card Kiri: Status Panggilan Saat Ini --}}
        <div class="col-lg-5 mb-3">
            <div class="card bg-dark text-white text-center h-100 shadow-lg position-relative overflow-hidden">
                <div class="card-body d-flex flex-column justify-content-center py-5">
                    <h6 class="text-uppercase text-white-50 letter-spacing-2 mb-3">Sedang Dipanggil</h6>

                    @if ($antrianSekarang)
                        <h1 class="display-1 fw-bold mb-0 text-white">{{ $antrianSekarang->queue_number }}</h1>
                        <h3 class="fw-light mt-2">{{ $antrianSekarang->patient->fullname }}</h3>
                        <div class="mt-3 badge bg-success fs-6 fw-normal px-3 py-2">
                            <i class="bi bi-door-open me-1"></i> {{ $antrianSekarang->room->room_name ?? 'Ruangan ?' }}
                        </div>
                    @else
                        <h1 class="display-1 fw-bold text-white-50">-</h1>
                        <h4 class="fw-light">Belum ada panggilan</h4>
                    @endif
                </div>
                {{-- Aksi Cepat untuk Antrian Saat Ini --}}
                {{-- ... Bagian Footer Card ... --}}
                @if ($antrianSekarang)
                    <div class="card-footer bg-white bg-opacity-10 border-0 p-0 d-flex">

                        {{-- Logika Tombol Kiri --}}
                        @if ($antrianSekarang->status == 'CALLED')
                            {{-- Tombol MASUK (Pemicu status SERVED & Room CONSULTATION) --}}
                            <button wire:click="mulaiLayani({{ $antrianSekarang->id }})"
                                class="btn btn-primary rounded-0 flex-fill py-3 fw-bold">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Ruangan
                            </button>
                        @else
                            {{-- Tombol SELESAI (Pemicu status COMPLETED & Room AVAILABLE) --}}
                            <button wire:click="selesaiLayani({{ $antrianSekarang->id }})"
                                class="btn btn-success rounded-0 flex-fill py-3 fw-bold">
                                <i class="bi bi-check-lg me-1"></i> Selesai
                            </button>
                        @endif

                        {{-- Tombol Kanan (Lewati) --}}
                        <button wire:click="tandaiTerlewat({{ $antrianSekarang->id }})"
                            class="btn btn-danger rounded-0 flex-fill py-3 fw-bold border-start border-white border-opacity-25"
                            onclick="return confirm('Lewati pasien ini?') || event.stopImmediatePropagation()">
                            <i class="bi bi-bell-slash me-1"></i> Lewati
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Card Kanan: Kontrol Antrian --}}
        <div class="col-lg-7">
            <div class="row g-3 h-100">
                {{-- Baris 1: Antrian Berikutnya (Next) --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Antrian Selanjutnya</h6>
                                <div class="d-flex align-items-baseline">
                                    <h2 class="fw-bold mb-0 text-primary me-3">
                                        {{ $antrianSelanjutnya ? $antrianSelanjutnya->queue_number : '-' }}
                                    </h2>
                                    @if ($antrianSelanjutnya)
                                        <span class="text-dark">{{ $antrianSelanjutnya->patient->fullname }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada antrian menunggu</span>
                                    @endif
                                </div>
                            </div>
                            <button wire:click="panggilSelanjutnya" class="btn btn-primary btn-lg px-4 py-3 shadow-sm"
                                {{ !$antrianSelanjutnya ? 'disabled' : '' }}>
                                <i class="bi bi-megaphone-fill me-2"></i> Panggil Berikutnya
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Baris 2: Antrian Terlewat (Missed) --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-100 bg-light-danger border-start border-danger border-5">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-danger text-uppercase small fw-bold mb-1">Daftar Terlewat</h6>
                                <div class="d-flex align-items-center">
                                    <h3 class="fw-bold mb-0 text-danger me-2">{{ $antrianTerlewatCount }}</h3>
                                    <span class="text-muted small">Pasien tidak hadir</span>
                                </div>
                            </div>
                            @if ($antrianTerlewatCount > 0)
                                <div class="dropdown">
                                    <button class="btn btn-outline-danger dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Panggil Ulang
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        @foreach ($listTerlewat as $missed)
                                            <li>
                                                <button
                                                    class="dropdown-item d-flex justify-content-between align-items-center"
                                                    wire:click="panggilUlang({{ $missed->id }})">
                                                    <span>
                                                        <strong>{{ $missed->queue_number }}</strong> -
                                                        {{ $missed->patient->fullname }}
                                                    </span>
                                                    <i class="bi bi-arrow-counterclockwise ms-3"></i>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <button class="btn btn-secondary disabled">Nihil</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 2: Form Input Antrian Baru --}}
    <div class="card mb-4 border-0 shadow-sm bg-white">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle me-2"></i>Registrasi Antrian Baru</h5>
        </div>
        <div class="card-body">
            <div class="row align-items-end g-3">
                {{-- Input Pasien --}}
                <div class="col-md-6 position-relative">
                    <label class="form-label small text-muted fw-bold">Cari Pasien</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control form-control-lg" wire:model.live="searchPasien"
                            placeholder="Ketik nama atau NIK pasien..." {{ $selectedPasienId ? 'readonly' : '' }}>
                        @if ($selectedPasienId)
                            <button class="btn btn-outline-secondary" wire:click="resetSelection">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        @endif
                    </div>

                    {{-- Suggestion Dropdown --}}
                    @if (!empty($listPasienSuggestion))
                        <div class="list-group position-absolute w-100 shadow mt-1 overflow-auto"
                            style="max-height: 200px; z-index: 1000;">
                            @foreach ($listPasienSuggestion as $p)
                                <button type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                    wire:click="selectPasien({{ $p->id }}, '{{ $p->fullname }}')">
                                    <div>
                                        <div class="fw-bold">{{ $p->fullname }}</div>
                                        <small class="text-muted">{{ $p->nik }}</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Input Ruangan (Opsional) --}}
                <div class="col-md-4">
                    <label class="form-label small text-muted fw-bold">Preferensi Dokter/Ruangan <span
                            class="badge bg-light text-dark border">Opsional</span></label>
                    <select class="form-select form-select-lg" wire:model="selectedRoomId">
                        <option value="">-- Bebas (Sistem Acak) --</option>
                        @foreach ($rooms as $r)
                            <option value="{{ $r->id }}">{{ $r->room_name }} -
                                {{ $r->doctor->fullname ?? 'Umum' }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Submit --}}
                <div class="col-md-2">
                    <button wire:click="tambahAntrian" class="btn btn-dark w-100 btn-lg"
                        {{ !$selectedPasienId ? 'disabled' : '' }}>
                        <i class="bi bi-ticket-perforated me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 3: Tabel Data Antrian --}}
    <x-dashboard.content-card title="Daftar Antrian Hari Ini">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">No. Antrian</th>
                        <th width="30%">Nama Pasien</th>
                        <th width="15%">Status</th>
                        <th width="20%">Ruang/Dokter</th>
                        <th width="15%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($queues as $index => $q)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-light text-dark border fs-6">{{ $q->queue_number }}</span>
                            </td>
                            <td class="fw-bold">{{ $q->patient->fullname }}</td>
                            <td>
                                @if ($q->status == 'WAITING')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass me-1"></i>
                                        Menunggu</span>
                                @elseif($q->status == 'CALLED')
                                    <span class="badge bg-primary"><i class="bi bi-megaphone me-1"></i>
                                        Dipanggil</span>
                                @elseif($q->status == 'SERVED')
                                    <span class="badge bg-info text-dark"><i class="bi bi-heart-pulse me-1"></i>
                                        Diperiksa</span>
                                @elseif($q->status == 'MISSED')
                                    <span class="badge bg-danger"><i class="bi bi-slash-circle me-1"></i>
                                        Terlewat</span>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-check-all me-1"></i>
                                        Selesai</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $q->room->room_name ?? '-' }} <br>
                                <small class="fst-italic">{{ $q->room->doctor->fullname ?? '' }}</small>
                            </td>
                            <td class="text-end">
                                @if ($q->status == 'WAITING')
                                    <button wire:click="forcePanggil({{ $q->id }})"
                                        class="btn btn-sm btn-outline-primary" title="Panggil">
                                        <i class="bi bi-play-fill"></i>
                                    </button>
                                    <button wire:click="batalAntrian({{ $q->id }})"
                                        class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @elseif ($q->status == 'CALLED')
                                    <button wire:click="mulaiLayani({{ $q->id }})"
                                        class="btn btn-sm btn-primary" title="Masuk Ruangan">
                                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                                    </button>
                                @elseif ($q->status == 'SERVED')
                                    <button wire:click="selesaiLayani({{ $q->id }})"
                                        class="btn btn-sm btn-success" title="Selesai">
                                        <i class="bi bi-check"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada antrian hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-dashboard.content-card>

    {{-- Tambahkan ini di atas konten antrian --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

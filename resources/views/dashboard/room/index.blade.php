@extends('layouts.dashboard')

@section('title', 'Manajemen Ruangan')

@section('content')

    <x-dashboard.content-card title="Daftar Ruangan & Dokter">
        <div class="d-flex justify-content-between mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roomModal"
                onclick="resetForm()">
                <i class="bi bi-plus-lg me-2"></i> Tambah Ruangan
            </button>

            {{-- Filter Status --}}
            {{-- <div class="d-flex gap-2">
                <span
                    class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-circle-fill me-2" style="font-size: 8px;"></i> Available
                </span>
                <span
                    class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-circle-fill me-2" style="font-size: 8px;"></i> Available
                </span>
                <span
                    class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-circle-fill me-2" style="font-size: 8px;"></i> Consultation
                </span>
            </div> --}}
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle border-top">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="30%">Nama Ruangan</th>
                        <th width="35%">Dokter Bertugas</th>
                        <th width="15%" class="text-center">Status Saat Ini</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-3 text-primary">
                                        <i class="bi bi-hospital fs-4"></i>
                                    </div>
                                    <span class="fw-bold fs-6">{{ $room->room_name }}</span>
                                </div>
                            </td>
                            <td>
                                @if ($room->doctor)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-2 rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px; font-size: 12px;">
                                            {{ substr($room->doctor->fullname, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="d-block fw-bold text-dark">{{ $room->doctor->fullname }}</span>
                                            <small class="text-muted" style="font-size: 0.75rem;">SIP:
                                                {{ $room->doctor->sip ?? '-' }}</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-secondary text-white fw-normal">
                                        <i class="bi bi-person-x me-1"></i> Belum ada dokter
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($room->status == 'AVAILABLE')
                                    <span class="badge bg-success rounded-pill px-3">
                                        <i class="bi bi-check-circle me-1"></i> Tersedia
                                    </span>
                                @elseif ($room->status == 'BREAK')
                                    <span class="badge bg-warning rounded-pill px-3">
                                        <i class="bi bi-check-circle me-1"></i> Istirahat
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3">
                                        <i class="bi bi-activity me-1"></i> Ada Pasien
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-light border text-warning btn-edit"
                                    data-id="{{ $room->id }}" data-name="{{ $room->room_name }}"
                                    data-doctor="{{ $room->doctor_id }}" data-bs-toggle="modal" data-bs-target="#roomModal">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-light border text-danger"
                                    onclick="confirmDelete({{ $room->id }}, '{{ $room->room_name }}')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data ruangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-dashboard.content-card>

    <div class="modal fade" id="roomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="roomForm" action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div id="methodField"></div> {{-- Untuk inject @method('PUT') saat edit --}}

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Ruangan</label>
                            <input type="text" name="room_name" id="room_name" class="form-control"
                                placeholder="Contoh: Poli Umum 1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Dokter Penanggung Jawab</label>
                            <select name="doctor_id" id="doctor_id" class="form-select">
                                <option value="">-- Kosongkan / Dokter Umum --</option>
                                @foreach ($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->fullname }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted">
                                Dokter yang dipilih akan otomatis di-assign ke ruangan ini saat antrian berjalan.
                            </div>
                        </div>

                        {{-- Status biasanya otomatis, tapi admin butuh override manual jika error --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Reset Status (Override)</label>
                            <select name="status" id="status" class="form-select bg-light">
                                <option value="AVAILABLE">Available (Kosong)</option>
                                <option value="CONSULTATION">Consultation (Sedang Periksa)</option>
                            </select>
                            <div class="form-text text-warning">
                                *Hanya ubah manual jika sistem antrian macet.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Sederhana untuk Modal Edit --}}
    <script>
        const roomModal = document.getElementById('roomModal');
        const form = document.getElementById('roomForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        function resetForm() {
            form.action = "{{ route('rooms.store') }}";
            form.reset();
            methodField.innerHTML = '';
            modalTitle.innerText = "Tambah Ruangan";
        }

        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                let name = this.getAttribute('data-name');
                let doctor = this.getAttribute('data-doctor');

                form.action = `/dashboard/rooms/${id}`; // Sesuaikan route update kamu
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                modalTitle.innerText = "Edit Ruangan";

                document.getElementById('room_name').value = name;
                document.getElementById('doctor_id').value = doctor;
            });
        });
    </script>
    {{-- Script untuk Delete (SweetAlert / Konfirmasi Biasa) --}}
    <script>
        function confirmDelete(id, name) {
            if (confirm(`Apakah Anda yakin ingin menghapus ruangan ${name}?`)) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = `/dashboard/rooms/${id}`;

                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Method Delete
                let methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection

@extends('layouts.dashboard')

@section('title', 'Manajemen Pasien')

@section('content')

    <x-dashboard.content-card title="Daftar Pasien">
        {{-- Header Tools --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-1"></i> Pasien Baru
            </button>

            <form action="{{ route('patients.index') }}" method="GET" class="d-flex w-100 w-md-auto"
                style="max-width: 400px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau NIK..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary px-3">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle border-top">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Nama Lengkap</th>
                        <th width="20%">NIK</th>
                        <th width="15%" class="text-center">L/P</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $key => $patient)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $patients->firstItem() + $key }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $patient->fullname }}</span>
                                    <small class="text-muted">
                                        <i class="bi bi-telephone-fill me-1" style="font-size: 0.7rem;"></i>
                                        {{ $patient->phone_number ?? '-' }}
                                    </small>
                                </div>
                            </td>
                            <td class="text-muted font-monospace">{{ $patient->nik ?? '-' }}</td>
                            <td class="text-center">
                                @if ($patient->gender == 'M')
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 rounded-pill">Laki-Laki</span>
                                @else
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 rounded-pill">Perempuan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- Tombol Detail --}}
                                    <button class="btn btn-light border text-info btn-detail" title="Detail"
                                        data-fullname="{{ $patient->fullname }}" data-nik="{{ $patient->nik }}"
                                        data-phone="{{ $patient->phone_number }}" data-address="{{ $patient->address }}"
                                        data-gender="{{ $patient->gender }}" data-birthdate="{{ $patient->birthdate }}"
                                        data-note="{{ $patient->note }}" data-bs-toggle="modal"
                                        data-bs-target="#detailModal">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>

                                    {{-- Tombol Edit --}}
                                    <button class="btn btn-light border text-warning btn-edit" title="Edit"
                                        data-id="{{ $patient->id }}" data-fullname="{{ $patient->fullname }}"
                                        data-nik="{{ $patient->nik }}" data-phone="{{ $patient->phone_number }}"
                                        data-address="{{ $patient->address }}" data-gender="{{ $patient->gender }}"
                                        data-birthdate="{{ $patient->birthdate }}" data-note="{{ $patient->note }}"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button class="btn btn-light border text-danger btn-delete" title="Hapus"
                                        data-id="{{ $patient->id }}" data-fullname="{{ $patient->fullname }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-frown fs-1 d-block mb-2"></i>
                                Belum ada data pasien ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $patients->links('pagination::bootstrap-5') }}
        </div>
    </x-dashboard.content-card>

    {{-- MODAL CREATE --}}
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Pasien Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('patients.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @include('dashboard.patient.form')
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Data Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @include('dashboard.patient.form')
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white px-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Detail Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped mb-0">
                        <tr>
                            <th width="35%" class="ps-4">Nama Lengkap</th>
                            <td id="view_fullname" class="fw-bold text-primary"></td>
                        </tr>
                        <tr>
                            <th class="ps-4">NIK</th>
                            <td id="view_nik"></td>
                        </tr>
                        <tr>
                            <th class="ps-4">No HP</th>
                            <td id="view_phone"></td>
                        </tr>
                        <tr>
                            <th class="ps-4">Tgl Lahir</th>
                            <td id="view_birthdate"></td>
                        </tr>
                        <tr>
                            <th class="ps-4">Gender</th>
                            <td id="view_gender"></td>
                        </tr>
                        <tr>
                            <th class="ps-4">Alamat</th>
                            <td id="view_address" class="text-wrap"></td>
                        </tr>
                        <tr>
                            <th class="ps-4">Catatan</th>
                            <td id="view_note" class="text-muted fst-italic"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formDelete" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body py-4">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus data pasien <strong id="delete_name"
                                class="text-dark"></strong>?</p>
                        <small class="text-danger">Data yang dihapus tidak dapat dikembalikan.</small>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Modal EDIT
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                var id = button.getAttribute('data-id');
                var fullname = button.getAttribute('data-fullname');
                var nik = button.getAttribute('data-nik');
                var phone = button.getAttribute('data-phone');
                var address = button.getAttribute('data-address');
                var gender = button.getAttribute('data-gender');
                var birthdate = button.getAttribute('data-birthdate');
                var note = button.getAttribute('data-note');

                var modal = this;
                modal.querySelector('#formEdit').action = '/dashboard/patients/' + id;
                modal.querySelector('[name="fullname"]').value = fullname;
                modal.querySelector('[name="nik"]').value = nik;
                modal.querySelector('[name="phone_number"]').value = phone;
                modal.querySelector('[name="address"]').value = address;
                modal.querySelector('[name="gender"]').value = gender;
                modal.querySelector('[name="birthdate"]').value = birthdate;
                modal.querySelector('[name="note"]').value = note;
            });

            // Modal DETAIL
            var detailModal = document.getElementById('detailModal');
            detailModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                this.querySelector('#view_fullname').textContent = button.getAttribute('data-fullname');
                this.querySelector('#view_nik').textContent = button.getAttribute('data-nik') || '-';
                this.querySelector('#view_phone').textContent = button.getAttribute('data-phone') || '-';
                this.querySelector('#view_address').textContent = button.getAttribute('data-address') ||
                    '-';
                this.querySelector('#view_note').textContent = button.getAttribute('data-note') || '-';
                this.querySelector('#view_birthdate').textContent = button.getAttribute(
                    'data-birthdate') || '-';

                var gender = button.getAttribute('data-gender');
                this.querySelector('#view_gender').innerHTML = (gender === 'M') ?
                    '<span class="badge bg-primary">Laki-laki</span>' :
                    '<span class="badge bg-danger">Perempuan</span>';
            });

            // Modal DELETE
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-fullname');

                var modal = this;
                modal.querySelector('#formDelete').action = '/dashboard/patients/' + id;
                modal.querySelector('#delete_name').textContent = name;
            });
        });
    </script>

@endsection

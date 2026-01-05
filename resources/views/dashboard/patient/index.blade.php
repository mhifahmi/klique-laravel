@extends('layouts.dashboard')

@section('title', 'Manajemen Pasien')

@section('content')

    <x-dashboard.content-card title="Daftar Pasien">
        <div class="d-flex justify-content-between mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg"></i> Pasien Baru
            </button>

            <form action="{{ route('patients.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama/NIK..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>L/P</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $key => $patient)
                        <tr>
                            <td>{{ $patients->firstItem() + $key }}</td>
                            <td>
                                <span class="fw-bold">{{ $patient->fullname }}</span><br>
                                <small class="text-muted">{{ $patient->phone_number }}</small>
                            </td>
                            <td>{{ $patient->nik ?? '-' }}</td>
                            <td>
                                @if ($patient->gender == 'M')
                                    <span class="badge bg-primary">Laki-Laki</span>
                                @else
                                    <span class="badge bg-danger">Perempuan</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm text-white btn-detail"
                                    data-fullname="{{ $patient->fullname }}" data-nik="{{ $patient->nik }}"
                                    data-phone="{{ $patient->phone_number }}" data-address="{{ $patient->address }}"
                                    data-gender="{{ $patient->gender }}" data-bs-toggle="modal"
                                    data-bs-target="#detailModal">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $patient->id }}"
                                    data-fullname="{{ $patient->fullname }}" data-nik="{{ $patient->nik }}"
                                    data-phone="{{ $patient->phone_number }}" data-address="{{ $patient->address }}"
                                    data-gender="{{ $patient->gender }}" data-bs-toggle="modal"
                                    data-bs-target="#editModal">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $patient->id }}"
                                    data-fullname="{{ $patient->fullname }}" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada data pasien.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $patients->links('pagination::bootstrap-5') }}
        </div>
    </x-dashboard.content-card>


    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pasien Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('patients.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @include('dashboard.patient.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @include('dashboard.patient.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama</th>
                            <td id="view_fullname"></td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td id="view_nik"></td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td id="view_phone"></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td id="view_gender"></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td id="view_address"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formDelete" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data pasien <strong id="delete_name"></strong>?</p>
                        <small class="text-danger">Data yang dihapus tidak dapat dikembalikan.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Logic untuk Modal EDIT
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                // Ambil data dari tombol
                var id = button.getAttribute('data-id');
                var fullname = button.getAttribute('data-fullname');
                var nik = button.getAttribute('data-nik');
                var phone = button.getAttribute('data-phone');
                var address = button.getAttribute('data-address');
                var gender = button.getAttribute('data-gender');

                // Isi form di dalam modal
                var modal = this;
                modal.querySelector('#formEdit').action = '/dashboard/patients/' + id; // Update URL Action
                modal.querySelector('[name="fullname"]').value = fullname;
                modal.querySelector('[name="nik"]').value = nik;
                modal.querySelector('[name="phone_number"]').value = phone;
                modal.querySelector('[name="address"]').value = address;
                modal.querySelector('[name="gender"]').value = gender;
            });

            // 2. Logic untuk Modal DELETE
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-fullname');

                var modal = this;
                modal.querySelector('#formDelete').action = '/dashboard/patients/' + id;
                modal.querySelector('#delete_name').textContent = name;
            });

            // 3. Logic untuk Modal DETAIL
            var detailModal = document.getElementById('detailModal');
            detailModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                this.querySelector('#view_fullname').textContent = button.getAttribute('data-fullname');
                this.querySelector('#view_nik').textContent = button.getAttribute('data-nik');
                this.querySelector('#view_phone').textContent = button.getAttribute('data-phone');
                this.querySelector('#view_address').textContent = button.getAttribute('data-address');

                var gender = button.getAttribute('data-gender');
                this.querySelector('#view_gender').textContent = (gender === 'M') ? 'Laki-laki' :
                    'Perempuan';
            });
        });
    </script>

@endsection

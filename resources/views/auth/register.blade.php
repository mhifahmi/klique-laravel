<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Staff - Klinik Hoyong Damang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .row-login {
            height: 100vh;
        }

        /* BAGIAN KIRI (GAMBAR BEDA SEDIKIT/WARNA BEDA) */
        .left-side {
            /* Gambar Dokter/Tim Medis untuk nuansa pendaftaran staf */
            background: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=2070&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .overlay {
            background-color: rgba(0, 77, 64, 0.7);
            /* Hijau Gelap Transparan */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        /* BAGIAN KANAN */
        .right-side {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            /* Scroll jika form kepanjangan */
        }

        .form-container {
            width: 85%;
            max-width: 450px;
            padding: 20px;
        }

        .btn-register {
            background-color: #198754;
            color: white;
            border: none;
            font-weight: bold;
        }

        .btn-register:hover {
            background-color: #157347;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row row-login">

            <div class="col-md-5 left-side d-none d-md-block">
                <div class="overlay">
                    <h2 class="fw-bold">Bergabung Bersama Kami</h2>
                    <p class="fs-5">Sistem Administrasi Klinik Terpadu</p>
                </div>
            </div>

            <div class="col-md-7 right-side">
                <div class="form-container">
                    <h3 class="text-center mb-4 fw-bold text-success">Registrasi Staf Baru</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required
                                value="{{ old('name') }}" placeholder="Contoh: Budi Santoso">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" required
                                value="{{ old('username') }}" placeholder="Tanpa spasi, cth: budi_admin">
                            <small class="text-muted">Digunakan untuk login.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Role / Jabatan</label>
                            <select name="role" class="form-select">
                                <option value="STAFF">Staf Loket (Operator)</option>
                                <option value="ADMIN">Administrator (Super Admin)</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-register p-3 shadow-sm">Buat Akun</button>
                        </div>

                        <div class="text-center mt-3">
                            <small>Sudah punya akun? <a href="{{ route('login') }}"
                                    class="text-decoration-none text-success fw-bold">Login di sini</a></small>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>

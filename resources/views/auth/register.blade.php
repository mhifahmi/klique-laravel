<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Staff - Klique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #007bff;
            --primary-green: #28a745;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .row-login {
            height: 100vh;
        }

        /* --- LEFT SIDE (IMAGE) --- */
        .left-side {
            /* Gambar Tim Medis */
            background: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=2070&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .overlay {
            /* Gradasi Hijau lebih dominan untuk Register */
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.9) 0%, rgba(32, 201, 151, 0.8) 100%);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
            color: white;
        }

        /* --- RIGHT SIDE (SCROLLABLE FORM) --- */
        .right-side {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* Supaya bisa scroll kalau tinggi */
            padding-top: 5vh;
            overflow-y: auto;
            height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            padding-bottom: 50px;
        }

        .form-floating>.form-control {
            border-radius: 12px;
            border: 2px solid #f1f3f5;
            background-color: #fff;
        }

        .form-floating>.form-control:focus {
            border-color: var(--primary-green);
            /* Hijau saat fokus */
            box-shadow: none;
        }

        .btn-register {
            background: var(--primary-green);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px;
        }

        .btn-register:hover {
            background: #218838;
            color: white;
        }

        .info-box {
            background: #e3f2fd;
            border-left: 5px solid var(--primary-blue);
            padding: 15px;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #0d47a1;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row row-login">

            <div class="col-md-5 left-side d-none d-md-block">
                <div class="overlay">
                    <h2 class="fw-bold display-6 mb-3">Bergabung dengan Tim</h2>
                    <p class="fs-5 opacity-90">Daftarkan diri Anda untuk mengelola antrian dan pelayanan klinik.</p>
                </div>
            </div>

            <div class="col-md-7 right-side">
                <div class="form-container">
                    <div class="text-start mb-4">
                        <h3 class="fw-bold" style="color: var(--primary-green)">Registrasi Staf Baru</h3>
                        <p class="text-muted">Isi data diri Anda dengan benar.</p>
                    </div>

                    <div class="info-box">
                        <strong><i class="bi bi-info-circle-fill me-2"></i>Penting:</strong>
                        Akun baru memerlukan verifikasi dan persetujuan dari Administrator sebelum dapat digunakan untuk
                        Login.
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4 rounded-3 border-0 shadow-sm">
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                            <label for="name">Nama Lengkap</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="username"
                                placeholder="Username" value="{{ old('username') }}" required>
                            <label for="username">Username</label>
                            <div class="form-text ms-2">Tanpa spasi, contoh: <code>budi_admin</code></div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Password" required>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_conf" placeholder="Konfirmasi Password" required>
                                    <label for="password_conf">Ulangi Password</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-4">
                            <select name="role" class="form-select" id="role">
                                <option value="STAFF">Staf Loket (Operator)</option>
                                <option value="DOCTOR">Dokter</option>
                                <option value="ADMIN">Administrator</option>
                            </select>
                            <label for="role">Role / Jabatan</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-register">Buat Akun Saya</button>
                        </div>

                        <div class="text-center mt-4">
                            <small>Sudah memiliki akun aktif? <a href="{{ route('login') }}"
                                    class="text-decoration-none fw-bold" style="color: var(--primary-green)">Login
                                    sekarang</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

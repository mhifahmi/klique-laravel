<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Hoyong Damang</title>
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

        /* BAGIAN KIRI (GAMBAR) */
        .left-side {
            background: url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=2053&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        /* Overlay abu-abu transparan biar tulisan terbaca (Sesuai mockup agak gelap) */
        .overlay {
            background-color: rgba(255, 255, 255, 0.7);
            /* Putih transparan */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* BAGIAN KANAN (FORM) */
        .right-side {
            background-color: #e0e0e0;
            /* Warna abu-abu mockup */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            width: 80%;
            max-width: 400px;
        }

        .btn-login {
            background-color: #d3d3d3;
            /* Abu-abu gelap tombol */
            border: none;
            color: #000;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #b0b0b0;
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 5px solid #00c853;
            /* Hijau logo */
            font-size: 3rem;
            color: #00c853;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row row-login">

            <div class="col-md-7 left-side">
                <div class="overlay">
                    <div class="logo-circle">+</div>

                    <h2 class="fw-bold">Klinik Hoyong Damang</h2>
                    <p class="fst-italic fs-5">"Mens sana in corpore sano"</p>

                    <div style="position: absolute; bottom: 30px; font-size: 0.9rem;">
                        Jalan Terusan Belakang Indo April No.76, Kota Bandung
                    </div>
                </div>
            </div>

            <div class="col-md-5 right-side">
                <div class="form-container">
                    <h3 class="text-center mb-5 fw-bold">Masuk ke Aplikasi</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control p-3 border-0 shadow-sm"
                                style="background-color: #dcdcdc;" placeholder="" required
                                value="{{ old('username') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control p-3 border-0 shadow-sm"
                                style="background-color: #dcdcdc;" placeholder="" required>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-login p-3 shadow-sm">Sign In</button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">Lupa kata sandi? Segera hubungi Admin!</small>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>

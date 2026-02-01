<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klique - Sistem Antrian Klinik</title>

    @vite(['resources/css/bootstrap.min.css', 'resources/css/home.css', 'resources/js/bootstrap.bundle.min.js'])
</head>

<body>

    <div class="container main-container">

        <h1 class="app-title">{{config('klinik.name')}}</h1>
        <p class="app-subtitle">{{config('klinik.short_desc')}}</p>

        <div class="row justify-content-center w-100">

            <div class="col-md-5 col-lg-4 mb-4">
                <a href="{{ url('/queue-public') }}" class="card-link">
                    <div class="custom-card">
                        <div class="icon-wrapper">
                            <img src="{{ asset('assets/queue.png') }}" alt="Lihat Antrian" class="card-icon">
                        </div>
                        <h3 class="mb-2">Lihat Antrian</h3>
                        <p class="mb-0">Pantau nomor antrian secara live</p>
                    </div>
                </a>
            </div>

            <div class="col-md-5 col-lg-4 mb-4">
                <a href="{{ route('login') }}" class="card-link">
                    <div class="custom-card">
                        <div class="icon-wrapper">
                            <img src="{{ asset('assets/enter.png') }}" alt="Login Staff" class="card-icon">
                        </div>
                        <h3 class="mb-2">Login Staff</h3>
                        <p class="mb-0">Masuk ke dashboard administrasi</p>
                    </div>
                </a>
            </div>

        </div>

        <div style="margin-top: 50px; color: #adb5bd; font-size: 0.8rem;">
            &copy; {{ date('Y') }} Klique App. All rights reserved.
        </div>
    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klique - Sistem Antrian Klinik</title>

    @vite(['resources/css/bootstrap.min.css', 'resources/js/bootstrap.bundle.min.js'])

    <style>
        /* Container agar konten selalu di tengah layar secara vertikal & horizontal */
        .main-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Styling Judul */
        .app-title {
            font-weight: 800;
            /* Sangat tebal */
            font-size: 3rem;
            margin-bottom: 0.2rem;
        }

        .app-subtitle {
            font-size: 1.2rem;
            color: #000;
            margin-bottom: 3rem;
            font-weight: 500;
        }

        /* Styling Kotak Kartu (Card) */
        .custom-card {
            background-color: #dcdcdc;
            /* Warna abu-abu seperti gambar */
            border: 2px solid #000000;
            /* Border hitam tegas */
            border-radius: 25px;
            /* Sudut tumpul */
            padding: 40px 20px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            height: 100%;
            /* Agar tinggi kartu sama */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Sedikit bayangan */
        }

        /* Efek saat mouse diarahkan (Hover) */
        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            background-color: #d1d1d1;
        }

        /* Styling Icon */
        .card-icon {
            font-size: 5rem;
            /* Ukuran icon besar */
            color: #000;
            margin-bottom: 1rem;
        }

        /* Link agar bisa diklik tapi tidak terlihat seperti link biru biasa */
        .card-link {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>

<body>

    <div class="container main-container">

        <h1 class="app-title">Klique</h1>
        <p class="app-subtitle">Sistem Antrian Klinik</p>

        <div class="row justify-content-center w-100">

            <div class="col-md-5 col-lg-4 mb-4">
                <a href="{{ url('/queue-public') }}" class="card-link">
                    <div class="custom-card">
                        <img src="{{ asset('assets/queue.png') }}" alt="Icon antrian" class="card-icon" height="200">
                        <h3 class="fw-bold mb-2">Lihat Antrian</h3>
                        <p class="mb-0">Lihat langsung antrian sebagai pengunjung</p>
                    </div>
                </a>
            </div>

            <div class="col-md-5 col-lg-4 mb-4">
                <a href="{{ route('login') }}" class="card-link">
                    <div class="custom-card">
                        <img src="{{ asset('assets/enter.png') }}" alt="Icon antrian" class="card-icon" height="200" style="margin-left: -24px">
                        <h3 class="fw-bold mb-2">Login</h3>
                        <p class="mb-0">Masuk sebagai staff</p>
                    </div>
                </a>
            </div>

        </div>
    </div>

</body>

</html>

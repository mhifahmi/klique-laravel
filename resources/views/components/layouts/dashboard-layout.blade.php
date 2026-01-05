<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Klinik Hoyong Damang' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @livewireStyles
    <style>
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body>
    <div class="d-flex">

        <x-sidebar />

        <div class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h3 class="fw-bold text-dark">@yield('title')</h3>
                <div class="text-muted">
                    Halo, <span class="fw-bold text-primary">{{ Auth::user()->name ?? 'Staf' }}</span>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>

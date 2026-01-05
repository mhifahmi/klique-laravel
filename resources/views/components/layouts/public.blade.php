<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Klinik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/bootstrap.min.css', 'resources/js/bootstrap.bundle.min.js', 'resources/css/queue-public.css'])
</head>

<body style="background-color: white;">
    <div class="container-fluid py-4">
        {{ $slot }}
    </div>
</body>

</html>

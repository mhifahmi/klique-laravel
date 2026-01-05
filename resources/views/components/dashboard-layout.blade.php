<!DOCTYPE html>
<html lang="id">

<head>
    <title>{{ $title ?? 'Klinik' }}</title>
</head>

<body>
    <div class="d-flex">
        <x-sidebar />

        <div class="flex-grow-1 p-4 bg-light">
            {{ $slot }}
        </div>
    </div>
</body>

</html>

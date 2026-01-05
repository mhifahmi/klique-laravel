@props(['route', 'icon'])

@php
    // Cek apakah route saat ini cocok dengan link ini
    $active = request()->routeIs($route . '*');
    $classes = $active
                ? 'nav-link active bg-success text-white' // Style Active
                : 'nav-link text-dark';                   // Style Inactive
@endphp

<a href="{{ route($route) }}" class="{{ $classes }} mb-2">
    <i class="bi {{ $icon }} me-2"></i> {{ $slot }}
</a>

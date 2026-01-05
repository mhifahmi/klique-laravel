@props(['title', 'actionRoute' => null, 'actionText' => 'Tambah Data'])

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">{{ $title }}</h5>

        @if ($actionRoute)
        @endif
    </div>

    <div class="card-body">
        {{ $slot }}
    </div>
</div>

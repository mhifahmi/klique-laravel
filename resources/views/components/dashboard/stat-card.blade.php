@props(['title' => '', 'value' => '', 'icon' => '', 'color' => 'primary'])

<div class="card shadow-sm border-0">
    <div class="card-body d-flex align-items-center">
        <div class="bg-{{ $color }} text-white rounded p-3 me-3">
            <i class="bi {{ $icon }} fs-3"></i>
        </div>
        <div>
            <h6 class="text-muted mb-1">{{ $title }}</h6>
            <h3 class="fw-bold mb-0">{{ $value }}</h3>
        </div>
    </div>
</div>

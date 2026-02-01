@props(['title', 'value', 'icon', 'color' => 'primary', 'subTitle' => ''])

@pushOnce('styles')
    <style>
        .bg-gradient-danger {
            background: linear-gradient(to right, #ffbf96, #fe7096) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(to right, #90caf9, #047edf) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(to right, #84d9d2, #07cdae) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(to right, #ffd500f8, #e8bf07df) !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
        }

        .bg-gradient-dark {
            background: linear-gradient(to right, #5e5e5e, #3e3e3e) !important;
        }

        .card-img-absolute {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            opacity: 0.2;
        }

        .card-stat {
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
        }
    </style>
@endPushOnce

<div class="card card-stat bg-gradient-{{ $color }} shadow-sm border-0 text-white h-100">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="fw-normal mb-1">{{ $title }}</h4>

                <h2 class="mb-0 fw-bold mt-2">{{ $value }}</h2>
            </div>

            <div class="ms-3">
                <i class="bi {{ $icon }} fs-1 opacity-50"></i>
            </div>
        </div>

        @if ($subTitle)
            <div class="mt-3">
                <small class="">{{ $subTitle }}</small>
            </div>
        @endif
    </div>
</div>

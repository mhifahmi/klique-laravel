<div class="sidebar bg-white shadow-sm p-3 d-flex flex-column"
    style="width: 280px; height: 100vh; position: sticky; top: 0;">
    {{-- Logo Section --}}
    <div class="mb-4">
        <h4 class="fw-bold text-success"><i class="bi bi-hospital-fill me-2"></i>Klinik HD</h4>
        <small class="text-muted">Sistem Antrian & Rekam Medis</small>
    </div>

    {{-- Navigation Section --}}
    <div class="nav flex-column nav-pills flex-grow-1">
        <x-nav-link route="dashboard" icon="bi-grid">
            Dashboard
        </x-nav-link>

        <x-nav-link route="queue.index" icon="bi-people">
            Dashboard Antrian
        </x-nav-link>

        <x-nav-link route="patients.index" activeRule="patients.*" icon="bi-person-vcard">
            Dashboard Pasien
        </x-nav-link>

        <x-nav-link route="rooms.index" activeRule="rooms.*" icon="bi-door-open">
            Dashboard Ruangan
        </x-nav-link>

        <x-nav-link route="doctors.index" activeRule="doctors.*" icon="bi-heart-pulse">
            Dashboard Dokter
        </x-nav-link>
    </div>

    {{-- User Profile & Logout Section (Bottom) --}}
    <div class="border-top pt-3 mt-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                {{-- Avatar Placeholder --}}
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="lh-1">
                    <span class="d-block fw-bold text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <small class="text-muted">{{ Auth::user()->role }}</small>
                </div>
            </div>

            {{-- Logout Button --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm border-0" title="Keluar">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="sidebar bg-white shadow-sm p-3" style="width: 280px; min-height: 100vh;">
    <div class="mb-4">
        <h4><i class="bi bi-hospital"></i> Klinik Hoyong Damang</h4>
    </div>

    <div class="nav flex-column nav-pills">
        <x-nav-link route="dashboard" icon="bi-grid">
            Dashboard
        </x-nav-link>

        {{-- <x-nav-link route="dashboard.queue" icon="bi-people"> --}}
        <x-nav-link route="queue.index" icon="bi-people">
            Antrian
        </x-nav-link>

        <x-nav-link route="patients.index" activeRule="patients.*" icon="bi-person-vcard">
            Data Pasien
        </x-nav-link>

        <x-nav-link route="rooms.index" activeRule="rooms.*" icon="bi-door-open">
            Status Ruangan
        </x-nav-link>

        <x-nav-link route="doctors.index" activeRule="doctors.*" icon="bi-heart-pulse">
            Data Dokter
        </x-nav-link>
    </div>
</div>

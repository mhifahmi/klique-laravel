<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ... (logika hitung data $totalAntrian, dll) ...

        // PERHATIKAN INI:
        // Kita memanggil file yang ada di folder "resources/views/dashboard/index.blade.php"
        // Penulisannya menggunakan titik (.) sebagai pemisah folder.
        $totalAntrian = 10;
        $sisaAntrian = 10;
        $selesai = 10;
        $activeQueues = 10;
        return view('dashboard.index', compact('totalAntrian', 'sisaAntrian', 'selesai', 'activeQueues'));
    }
}

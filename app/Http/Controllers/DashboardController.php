<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $queuesToday = Queue::whereDate('date', $today)->get();

        $stats = [
            'total'     => $queuesToday->count(),
            'waiting'   => $queuesToday->where('status', 'WAITING')->count(),
            'completed' => $queuesToday->where('status', 'COMPLETED')->count(),
            'missed'    => $queuesToday->where('status', 'MISSED')->count(),
        ];

        $totalRooms = Room::count();
        $activeRooms = Room::where('status', 'AVAILABLE')->count();
        $roomAvailability = "{$activeRooms}/{$totalRooms}";

        $currentCall = Queue::whereDate('date', $today)
            ->where('status', 'CALLED')
            ->orderBy('updated_at', 'desc')
            ->first();

        $currentNumber = $currentCall ? $currentCall->queue_number : '-';

        // Data Chart Tren Kunjungan 7 Hari Terakhir
        // $chartData = Queue::select(DB::raw('DATE(date) as date'), DB::raw('count(*) as total'))
        //     ->where('date', '>=', Carbon::now()->subDays(6))
        //     ->groupBy('date')
        //     ->orderBy('date', 'asc')
        //     ->pluck('total', 'date');

        return view('dashboard.index', compact(
            'stats',
            'roomAvailability',
            'currentNumber'
            // ,'chartData'
        ));
    }
}

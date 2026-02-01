<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QueueDashboard extends Component
{
    public $searchPasien = '';
    public $selectedPasienId = null;
    public $selectedPasienName = null;
    public $selectedRoomId = '';
    public $listPasienSuggestion = [];

    public $searchTable = '';

    public function updatedSearchPasien()
    {
        if (strlen($this->searchPasien) < 2) {
            $this->listPasienSuggestion = [];
            $this->selectedPasienId = null;
            return;
        }
        $this->listPasienSuggestion = Patient::where('fullname', 'like', '%' . $this->searchPasien . '%')
            ->orWhere('nik', 'like', '%' . $this->searchPasien . '%')
            ->limit(5)->get();
    }

    public function selectPasien($id, $name)
    {
        $this->selectedPasienId = $id;
        $this->selectedPasienName = $name;
        $this->searchPasien = $name;
        $this->listPasienSuggestion = [];
    }

    public function resetSelection()
    {
        $this->reset(['searchPasien', 'selectedPasienId', 'selectedPasienName']);
    }

    public function tambahAntrian()
    {
        if (!$this->selectedPasienId) {
            session()->flash('error', 'Harap pilih pasien dari daftar pencarian.');
            return;
        }

        $exists = Queue::where('patient_id', $this->selectedPasienId)
            ->whereDate('created_at', Carbon::today())
            ->whereIn('status', ['WAITING', 'CALLED', 'SERVED', 'MISSED'])
            ->exists();

        if ($exists) {
            session()->flash('error', 'Pasien ini masih memiliki antrian aktif (Menunggu/Dipanggil/Terlewat) hari ini. Harap selesaikan terlebih dahulu.');
            return;
        }

        DB::transaction(function () {
            $roomIdToAssign = $this->selectedRoomId;

            if (empty($roomIdToAssign)) {
                $ruanganTersepi = Room::where('room_name', 'LIKE', '%Umum%')
                    ->withCount(['queues' => function ($query) {
                        $query->whereDate('created_at', Carbon::today());
                    }])
                    ->orderBy('queues_count', 'asc')
                    ->first();

                if ($ruanganTersepi) {
                    $roomIdToAssign = $ruanganTersepi->id;
                }
            }

            $lastQueue = Queue::whereDate('created_at', Carbon::today())
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            $nextNumberInt = 1;

            if ($lastQueue) {
                $parts = explode('-', $lastQueue->queue_number);

                if (isset($parts[1])) {
                    $nextNumberInt = intval($parts[1]) + 1;
                }
            }

            $newQueueString = 'A-' . str_pad($nextNumberInt, 3, '0', STR_PAD_LEFT);

            Queue::create([
                'queue_number' => $newQueueString,
                'patient_id'   => $this->selectedPasienId,
                'status'       => 'WAITING',
                'room_id'      => $roomIdToAssign,
                'date'         => Carbon::today(),
            ]);

            session()->flash('success', "Antrian #{$newQueueString} berhasil ditambahkan.");
        });

        $this->reset(['searchPasien', 'selectedPasienId', 'selectedPasienName', 'selectedRoomId']);
    }

    private function prosesPanggil(Queue $queue)
    {
        DB::transaction(function () use ($queue) {
            $targetRoom = null;

            if ($queue->room_id) {
                $targetRoom = Room::find($queue->room_id);
                if ($targetRoom && $targetRoom->status !== 'AVAILABLE') {
                    $currentOccupant = Queue::where('room_id', $targetRoom->id)
                        ->whereIn('status', ['CALLED', 'SERVED'])
                        ->whereDate('created_at', Carbon::today())
                        ->first();

                    if ($currentOccupant) {
                        $currentOccupant->update(['status' => 'MISSED']);
                    }

                    $targetRoom->update(['status' => 'AVAILABLE']);
                }
            } else {
                $targetRoom = Room::where('status', 'AVAILABLE')
                    ->lockForUpdate()
                    ->first();
            }

            if (!$targetRoom) {
                throw new \Exception('Ruangan penuh atau tidak ditemukan. Silakan selesaikan antrian sebelumnya manual.');
            }

            $queue->update([
                'status'   => 'CALLED',
                'room_id'  => $targetRoom->id,
                'call_at'  => now(),
            ]);

            $targetRoom->update(['status' => 'CONSULTATION']);
        });
    }

    public function panggilSelanjutnya()
    {
        $nextQueue = Queue::where('status', 'WAITING')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('id', 'asc')
            ->first();

        if (!$nextQueue) {
            session()->flash('error', 'Tidak ada antrian menunggu.');
            return;
        }

        try {
            $this->prosesPanggil($nextQueue);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function panggilTerlewat()
    {
        $missedQueue = Queue::where('status', 'MISSED')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('queue_number', 'asc')
            ->first();

        if (!$missedQueue) {
            session()->flash('error', 'Tidak ada data antrian terlewat.');
            return;
        }

        try {
            $this->prosesPanggil($missedQueue);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function panggilUlang($id)
    {
        $queue = Queue::find($id);
        if ($queue) {
            try {
                $this->prosesPanggil($queue);
            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
            }
        }
    }

    public function mulaiLayani($id)
    {
        $queue = Queue::find($id);

        if ($queue && $queue->status == 'CALLED') {
            DB::transaction(function () use ($queue) {
                $queue->update([
                    'status' => 'SERVED',
                ]);

                if ($queue->room_id) {
                    Room::where('id', $queue->room_id)->update(['status' => 'CONSULTATION']);
                }
            });
        }
    }

    public function forcePanggil($id)
    {
        DB::transaction(function () use ($id) {
            Queue::where('id', $id)->update([
                'status' => 'CALLED'
            ]);

            Room::where('id')->update(['status' => 'CONSULTATION']);
        });
    }

    public function batalAntrian($id)
    {
        $queue = Queue::find($id);
        if ($queue) {
            if ($queue->status == 'CALLED') {
                session()->flash('error', 'Tidak bisa membatalkan pasien yang sedang dipanggil.');
                return;
            }
            $queue->delete();
            session()->flash('success', 'Antrian dibatalkan.');
        }
    }

    public function selesaiLayani($id)
    {
        $queue = Queue::find($id);
        if ($queue) {
            DB::transaction(function () use ($queue) {
                $queue->update([
                    'status' => 'COMPLETED',
                    'finish_at' => now()
                ]);

                if ($queue->room_id) {
                    Room::where('id', $queue->room_id)->update(['status' => 'AVAILABLE']);
                }
            });
        }
    }

    public function tandaiTerlewat($id)
    {
        $queue = Queue::find($id);
        if ($queue) {
            DB::transaction(function () use ($queue) {
                $roomId = $queue->room_id;

                $queue->update([
                    'status' => 'MISSED'
                ]);

                if ($roomId) {
                    Room::where('id', $roomId)->update(['status' => 'AVAILABLE']);
                }
            });
        }
    }

    public function panggilOtomatis()
    {
        $missed = Queue::where('status', 'MISSED')->whereDate('created_at', Carbon::today())->first();
        if ($missed) {
            try {
                $this->prosesPanggil($missed);
                return;
            } catch (\Exception $e) {
            }
        }

        $this->panggilSelanjutnya();
    }

    public function render()
    {
        $today = Carbon::today();

        $antrianSekarang = Queue::with(['patient', 'room'])
            ->whereIn('status', ['CALLED'])
            ->whereDate('created_at', $today)
            ->orderBy('updated_at', 'desc')
            ->first();

        $antrianSelanjutnya = Queue::with('patient')
            ->where('status', 'WAITING')
            ->whereDate('created_at', $today)
            ->orderBy('id', 'asc')
            ->first();

        $listTerlewat = Queue::with('patient')
            ->where('status', 'MISSED')
            ->whereDate('created_at', $today)
            ->get();

        $queues = Queue::with(['patient', 'room.doctor'])
            ->whereDate('created_at', $today)
            ->when($this->searchTable, function ($q) {
                $q->whereHas('patient', function ($sub) {
                    $sub->where('fullname', 'like', '%' . $this->searchTable . '%');
                })->orWhere('queue_number', 'like', '%' . $this->searchTable . '%');
            })
            ->orderByRaw("FIELD(status, 'CALLED', 'SERVED', 'WAITING', 'MISSED', 'COMPLETED')")
            ->orderBy('id', 'asc')
            ->get();

        $rooms = Room::with('doctor')->get();

        return view('livewire.queue-dashboard', [
            'antrianSekarang'      => $antrianSekarang,
            'antrianSelanjutnya'   => $antrianSelanjutnya,
            'listTerlewat'         => $listTerlewat,
            'antrianTerlewatCount' => $listTerlewat->count(),
            'queues'               => $queues,
            'rooms'                => $rooms
        ]);
    }
}

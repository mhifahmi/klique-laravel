<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('doctor')->latest()->get();
        $doctors = Doctor::all();

        return view('dashboard.room.index', compact('rooms', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'doctor_id' => 'nullable|exists:doctors,id',
            'status'    => 'nullable|in:AVAILABLE,CONSULTATION,BREAK',
        ], [
            'room_name.required' => 'Nama ruangan wajib diisi.',
            'doctor_id.exists'   => 'Dokter yang dipilih tidak valid.',
            'status.in'          => 'Status ruangan tidak valid.',
        ]);

        if (empty($validated['doctor_id'])) {
            $validated['status'] = 'BREAK';
        } elseif (empty($validated['status'])) {
            $validated['status'] = 'AVAILABLE';
        }

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'doctor_id' => 'nullable|exists:doctors,id',
            'status'    => 'nullable|in:AVAILABLE,CONSULTATION,BREAK',
        ], [
            'room_name.required' => 'Nama ruangan wajib diisi.',
            'doctor_id.exists'   => 'Dokter yang dipilih tidak valid.',
        ]);

        if (empty($validated['doctor_id'])) {
            $validated['status'] = 'BREAK';
        }

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Data ruangan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil dihapus');
    }
}

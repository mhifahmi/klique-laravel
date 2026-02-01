<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();

        if ($request->has('search')) {
            $query->where('fullname', 'like', '%' . $request->search . '%')
                ->orWhere('nik', 'like', '%' . $request->search . '%')
                ->orWhere('sip_number', 'like', '%' . $request->search . '%');
        }

        $doctors = $query->latest()->paginate(10);

        return view('dashboard.doctor.index', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname'     => 'required|string|max:255',
            'nik'          => 'nullable|numeric|digits:16',
            'sip_number'   => 'required|string|max:255',
            'birthdate'    => 'required|date',
            'phone_number' => 'nullable|string|max:20',
            'gender'       => 'required|in:M,F',
            'address'      => 'nullable|string',
        ], [
            'fullname.required'   => 'Nama lengkap dokter wajib diisi.',
            'fullname.max'        => 'Nama terlalu panjang, maksimal 255 karakter.',

            'nik.numeric'         => 'NIK harus berupa angka.',
            'nik.digits'          => 'NIK harus berjumlah tepat 16 digit.',

            'sip_number.required' => 'Nomor SIP (Surat Izin Praktik) wajib diisi.',
            'sip_number.max'      => 'Nomor SIP terlalu panjang.',

            'birthdate.required'  => 'Tanggal lahir dokter wajib diisi.',
            'birthdate.date'      => 'Format tanggal lahir tidak valid.',

            'phone_number.max'    => 'Nomor telepon maksimal 20 digit.',

            'gender.required'     => 'Jenis kelamin wajib dipilih.',
            'gender.in'           => 'Pilihan jenis kelamin tidak valid.',
        ]);

        Doctor::create($validated);

        return redirect()->back()->with('success', 'Data Dokter berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'fullname'     => 'required|string|max:255',
            'nik'          => 'nullable|numeric|digits:16',
            'sip_number'   => 'required|string|max:255',
            'birthdate'    => 'required|date',
            'phone_number' => 'nullable|string|max:20',
            'gender'       => 'required|in:M,F',
            'address'      => 'nullable|string',
        ], [
            'fullname.required'   => 'Nama lengkap dokter wajib diisi.',
            'fullname.max'        => 'Nama terlalu panjang, maksimal 255 karakter.',

            'nik.numeric'         => 'NIK harus berupa angka.',
            'nik.digits'          => 'NIK harus berjumlah tepat 16 digit.',

            'sip_number.required' => 'Nomor SIP (Surat Izin Praktik) wajib diisi.',
            'sip_number.max'      => 'Nomor SIP terlalu panjang.',

            'birthdate.required'  => 'Tanggal lahir dokter wajib diisi.',
            'birthdate.date'      => 'Format tanggal lahir tidak valid.',

            'phone_number.max'    => 'Nomor telepon maksimal 20 digit.',

            'gender.required'     => 'Jenis kelamin wajib dipilih.',
            'gender.in'           => 'Pilihan jenis kelamin tidak valid.',
        ]);

        $doctor->update($validated);

        return redirect()->back()->with('success', 'Data Dokter berhasil diperbarui');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->back()->with('success', 'Data Dokter berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $query->where('fullname', 'like', '%' . $request->search . '%')
                ->orWhere('nik', 'like', '%' . $request->search . '%');
        }

        $patients = $query->latest()->paginate(10);

        return view('dashboard.patient.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname'     => 'required|string|max:255',
            'nik'          => 'nullable|numeric|digits:16',
            'birthdate'    => 'required|date',
            'phone_number' => 'nullable|string|max:20',
            'gender'       => 'required|in:M,F',
            'address'      => 'nullable|string',
            'note'         => 'nullable|string',
        ], [
            'fullname.required' => 'Nama lengkap pasien wajib diisi.',
            'fullname.max'      => 'Nama terlalu panjang, maksimal 255 karakter.',

            'nik.numeric'       => 'NIK harus berupa angka, tidak boleh ada huruf.',
            'nik.digits'        => 'NIK harus berjumlah tepat 16 digit sesuai KTP.',

            'birthdate.required' => 'Tanggal lahir wajib diisi.',
            'birthdate.date'    => 'Format tanggal lahir tidak valid.',

            'phone_number.max'  => 'Nomor telepon terlalu panjang (maksimal 20 angka).',

            'gender.required'   => 'Jenis kelamin wajib dipilih.',
            'gender.in'         => 'Pilihan jenis kelamin tidak valid (Pilih Laki-laki atau Perempuan).',
        ]);

        $data = $validated;

        Patient::create($data);

        return redirect()->back()->with('success', 'Pasien berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'fullname'     => 'required|string|max:255',
            'nik'          => 'nullable|numeric|digits:16',
            'birthdate'    => 'required|date',
            'phone_number' => 'nullable|string|max:20',
            'gender'       => 'required|in:M,F',
            'address'      => 'nullable|string',
            'note'         => 'nullable|string',
        ], [
            'fullname.required' => 'Nama lengkap pasien wajib diisi.',
            'fullname.max'      => 'Nama terlalu panjang, maksimal 255 karakter.',

            'nik.numeric'       => 'NIK harus berupa angka, tidak boleh ada huruf.',
            'nik.digits'        => 'NIK harus berjumlah tepat 16 digit sesuai KTP.',

            'birthdate.required' => 'Tanggal lahir wajib diisi.',
            'birthdate.date'    => 'Format tanggal lahir tidak valid.',

            'phone_number.max'  => 'Nomor telepon terlalu panjang (maksimal 20 angka).',

            'gender.required'   => 'Jenis kelamin wajib dipilih.',
            'gender.in'         => 'Pilihan jenis kelamin tidak valid (Pilih Laki-laki atau Perempuan).',
        ]);

        $data = $validated;

        $patient->update($data);

        return redirect()->back()->with('success', 'Data Pasien berhasil diperbarui');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->back()->with('success', 'Data Pasien berhasil dihapus');
    }
}

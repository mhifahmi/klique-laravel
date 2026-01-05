<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // start get data using query
        $query = Patient::query();

        if ($request->has('search')) {
            $query->where('fullname', 'like', '%' . $request->search . '%')
                ->orWhere('nik', 'like', '%' . $request->search . '%');
        }

        // Get 10 data perpage as default
        $patients = $query->latest()->paginate(10);

        // route to view
        return view('dashboard.patient.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname'     => 'required|string|max:255',
            'nik'          => 'nullable|numeric',
            'phone_number' => 'nullable|string',
            'gender'       => 'required|in:M,F',
            'address'       => 'nullable|string',
        ]);

        Patient::create($validated);

        return redirect()->back()->with('success', 'Pasien berhasil ditambahkan');
    }

    /**
     * Update Data (Edit)
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'fullname'     => 'required|string|max:255',
            'nik'          => 'nullable|numeric',
            'phone_number' => 'nullable|string',
            'gender'       => 'required|in:M,F',
            'address'       => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->back()->with('success', 'Data Pasien berhasil diperbarui');
    }

    /**
     * Hapus Data (Delete)
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->back()->with('success', 'Data Pasien berhasil dihapus');
    }
}

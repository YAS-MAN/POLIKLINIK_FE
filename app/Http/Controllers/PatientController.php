<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        
        $query = Patient::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('patient_code', 'like', "%{$search}%");
            });
        }
        
        if ($type) {
            $query->where('patient_type', $type);
        }
        
        $patients = $query->orderBy('name', 'asc')->paginate(10);
        
        return view('patients.index', compact('patients', 'search', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:patients,nik',
            'patient_type' => 'required|string|in:Murid,Pegawai,Keluarga Pegawai,Forsipa,Umum',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        $validated['patient_code'] = $this->generatePatientCode($validated['patient_type']);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Pasien baru berhasil didaftarkan dengan Kode: ' . $validated['patient_code']);
    }

    public function show($id)
    {
        $patient = Patient::with(['medicalRecords.doctor'])->findOrFail($id);
        $doctors = Doctor::orderBy('name', 'asc')->get();
        
        return view('patients.show', compact('patient', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:patients,nik,' . $id,
            'patient_type' => 'required|string|in:Murid,Pegawai,Keluarga Pegawai,Forsipa,Umum',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        // If the patient type changed, we regenerate the patient code to match the prefix
        if ($patient->patient_type !== $validated['patient_type']) {
            $validated['patient_code'] = $this->generatePatientCode($validated['patient_type']);
        }

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus!');
    }

    private function generatePatientCode($type)
    {
        $prefix = 'E';
        if ($type === 'Murid') $prefix = 'A';
        elseif ($type === 'Pegawai') $prefix = 'B';
        elseif ($type === 'Keluarga Pegawai') $prefix = 'C';
        elseif ($type === 'Forsipa') $prefix = 'D';
        
        do {
            $code = $prefix . mt_rand(100000, 999999);
        } while (Patient::where('patient_code', $code)->exists());
        
        return $code;
    }
}

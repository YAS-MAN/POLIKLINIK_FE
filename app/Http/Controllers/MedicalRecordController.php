<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function create(Request $request)
    {
        $selectedPatientId = $request->input('patient_id');
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();
        $medicines = Medicine::where('stock', '>', 0)->orderBy('name', 'asc')->get();

        return view('rme.create', compact('patients', 'doctors', 'medicines', 'selectedPatientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'complaints' => 'required|string',
            'physical_check' => 'nullable|string',
            'diagnosis' => 'required|string',
            'action_taken' => 'nullable|string',
            'disease' => 'nullable|string',
            'medicine_id' => 'nullable|exists:medicines,id',
            'medicine_qty' => 'nullable|integer|min:1',
            'prescription_notes' => 'nullable|string',
        ]);

        $prependedNotes = $request->input('prescription_notes') ?? '';
        if ($request->filled('medicine_id') && $request->filled('medicine_qty')) {
            $medicine = Medicine::find($request->input('medicine_id'));
            $qty = intval($request->input('medicine_qty'));
            
            if ($medicine->stock >= $qty) {
                $medicine->stock -= $qty;
                $medicine->save();
                
                $drugPrescription = "{$medicine->name} qty: {$qty} ({$medicine->dosage_rule})";
                $prependedNotes = $prependedNotes 
                    ? $drugPrescription . "\n" . $prependedNotes 
                    : $drugPrescription;
            } else {
                return back()->withErrors(['medicine_qty' => "Stok obat {$medicine->name} tidak mencukupi (sisa: {$medicine->stock})."])->withInput();
            }
        }

        MedicalRecord::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => now()->toDateString(),
            'appointment_time' => now()->format('h:i A'),
            'complaints' => $validated['complaints'],
            'physical_check' => $validated['physical_check'],
            'diagnosis' => $validated['diagnosis'],
            'action_taken' => $validated['action_taken'],
            'disease' => $validated['disease'] ?? 'General Checkup',
            'prescription_notes' => $prependedNotes,
            'status' => 'Draft' // Initially open for edits
        ]);

        return redirect()->route('patients.show', $validated['patient_id'])
            ->with('success', 'Draf Pemeriksaan Medis (RME) baru berhasil disimpan!');
    }

    public function edit($id)
    {
        $record = MedicalRecord::findOrFail($id);
        if ($record->status === 'Closed') {
            return redirect()->route('patients.show', $record->patient_id)
                ->with('error', 'Rekam medis ini sudah dikunci dan tidak dapat diubah!');
        }

        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();
        $medicines = Medicine::where('stock', '>', 0)->orderBy('name', 'asc')->get();

        return view('rme.edit', compact('record', 'patients', 'doctors', 'medicines'));
    }

    public function update(Request $request, $id)
    {
        $record = MedicalRecord::findOrFail($id);
        if ($record->status === 'Closed') {
            return redirect()->route('patients.show', $record->patient_id)
                ->with('error', 'Rekam medis ini sudah dikunci dan tidak dapat diubah!');
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'complaints' => 'required|string',
            'physical_check' => 'nullable|string',
            'diagnosis' => 'required|string',
            'action_taken' => 'nullable|string',
            'disease' => 'nullable|string',
            'prescription_notes' => 'nullable|string',
        ]);

        $record->update($validated);

        return redirect()->route('patients.show', $validated['patient_id'])
            ->with('success', 'Rekam Medis Elektronik (RME) berhasil diperbarui!');
    }

    public function lock($id)
    {
        $record = MedicalRecord::findOrFail($id);
        $record->status = 'Closed';
        $record->save();

        return redirect()->route('patients.show', $record->patient_id)
            ->with('success', 'Rekam medis pasien berhasil dikunci secara permanen!');
    }
}

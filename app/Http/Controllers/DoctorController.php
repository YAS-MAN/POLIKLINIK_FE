<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('name', 'asc')->get();
        return view('nakes.index', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Not Available',
        ]);

        Doctor::create($validated);

        return redirect()->route('nakes.index')->with('success', 'Data tenaga kesehatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'status' => 'required|string|in:Available,Not Available',
        ]);

        $doctor->update($validated);

        return redirect()->route('nakes.index')->with('success', 'Data tenaga kesehatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('nakes.index')->with('success', 'Data tenaga kesehatan berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->status = $doctor->status === 'Available' ? 'Not Available' : 'Available';
        $doctor->save();

        return redirect()->route('nakes.index')->with('success', 'Status praktik dokter ' . $doctor->name . ' berhasil diubah menjadi ' . ($doctor->status === 'Available' ? 'Aktif' : 'Tidak Aktif'));
    }
}

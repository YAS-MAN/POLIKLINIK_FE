<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::orderBy('name', 'asc')->get();
        return view('poli.index', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:polis,code',
            'base_tariff' => 'required|numeric|min:0',
        ]);

        Poli::create($validated);

        return redirect()->route('poli.index')->with('success', 'Data Poli & Layanan baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $poli = Poli::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:polis,code,' . $id,
            'base_tariff' => 'required|numeric|min:0',
        ]);

        $poli->update($validated);

        return redirect()->route('poli.index')->with('success', 'Data Poli & Layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()->route('poli.index')->with('success', 'Data Poli & Layanan berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Procurement;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    // Display apotek inventory list
    public function index()
    {
        $medicines = Medicine::orderBy('name', 'asc')->get();
        
        $lowStockMedicines = Medicine::whereRaw('stock <= min_stock')->get();
        
        $sixMonthsFromNow = now()->addMonths(6)->toDateString();
        $expiringMedicines = Medicine::where('expire_date', '<=', $sixMonthsFromNow)
            ->where('expire_date', '>=', now()->toDateString())
            ->get();

        return view('medicines.index', compact('medicines', 'lowStockMedicines', 'expiringMedicines'));
    }

    // Display drug procurement and transaction history
    public function pengadaan()
    {
        $medicines = Medicine::orderBy('name', 'asc')->get();
        $procurements = Procurement::with('medicine')->orderBy('id', 'desc')->get();
        
        $lowStockMedicines = Medicine::whereRaw('stock <= min_stock')->get();
        $sixMonthsFromNow = now()->addMonths(6)->toDateString();
        $expiringMedicines = Medicine::where('expire_date', '<=', $sixMonthsFromNow)
            ->where('expire_date', '>=', now()->toDateString())
            ->get();

        return view('medicines.pengadaan', compact('medicines', 'procurements', 'lowStockMedicines', 'expiringMedicines'));
    }

    public function storeProcurement(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'supplier_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Procurement::create([
            'medicine_id' => $validated['medicine_id'],
            'supplier_name' => $validated['supplier_name'],
            'quantity' => $validated['quantity'],
            'status' => 'Proposed',
            'order_date' => now()->toDateString()
        ]);

        return redirect()->route('medicines.pengadaan')->with('success', 'Usulan pengadaan obat berhasil diajukan!');
    }

    public function updateProcurementStatus(Request $request, $id)
    {
        $procurement = Procurement::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['Approved', 'Received'])) {
            return back()->with('error', 'Status tidak valid!');
        }

        $procurement->status = $status;
        
        if ($status === 'Received') {
            $procurement->receive_date = now()->toDateString();
            
            $medicine = $procurement->medicine;
            $medicine->stock += $procurement->quantity;
            $medicine->save();
        }

        $procurement->save();

        $message = $status === 'Received' 
            ? "Pengadaan selesai! Stok obat {$procurement->medicine->name} telah ditambah sebanyak {$procurement->quantity}." 
            : "Usulan pengadaan telah disetujui.";

        return redirect()->route('medicines.pengadaan')->with('success', $message);
    }
}

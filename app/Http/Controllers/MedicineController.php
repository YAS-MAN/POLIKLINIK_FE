<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Procurement;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    // 1. Data Gudang Obat
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->has('campus') && $request->campus != '') {
            $query->where('campus_name', $request->campus);
        }

        $medicines = $query->orderBy('name', 'asc')->get();
        
        $lowStockMedicines = Medicine::whereRaw('stock <= min_stock')->get();
        $sixMonthsFromNow = now()->addMonths(6)->toDateString();
        $expiringMedicines = Medicine::where('expire_date', '<=', $sixMonthsFromNow)
            ->where('expire_date', '>=', now()->toDateString())
            ->get();

        return view('medicines.index', compact('medicines', 'lowStockMedicines', 'expiringMedicines'));
    }

    // Store Medicine
    public function storeMedicine(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'package' => 'nullable|string|max:100',
            'expire_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        Medicine::create([
            'name' => strtoupper($validated['name']),
            'generic_name' => strtoupper($validated['name']),
            'category' => 'Obat Bebas',
            'formulation' => $validated['unit'] ?? 'Tablet',
            'package' => $validated['package'] ?? 'botol',
            'stock' => $validated['stock'],
            'min_stock' => $validated['min_stock'] ?? 0,
            'purchase_price' => $validated['purchase_price'] ?? 5000,
            'expire_date' => $validated['expire_date'] ?? '2030-01-01',
            'is_active' => $request->has('is_active') ? 1 : 0,
            'campus_name' => 'Gudang Pusat'
        ]);

        return redirect()->route('medicines.index')->with('success', 'Data obat baru berhasil ditambahkan!');
    }

    // Update Medicine
    public function updateMedicine(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->name = strtoupper($request->input('name', $medicine->name));
        $medicine->package = $request->input('package', $medicine->package);
        $medicine->expire_date = $request->input('expire_date', $medicine->expire_date);
        $medicine->purchase_price = $request->input('purchase_price', $medicine->purchase_price);
        $medicine->formulation = $request->input('unit', $medicine->formulation);
        $medicine->stock = $request->input('stock', $medicine->stock);
        $medicine->min_stock = $request->input('min_stock', $medicine->min_stock);
        $medicine->is_active = $request->has('is_active') ? 1 : 0;
        $medicine->save();

        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    // Delete Medicine
    public function destroyMedicine($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil dihapus!');
    }

    // 2. Transaksi Pembelian Obat & Input No. Faktur Modal
    public function pengadaan()
    {
        $medicines = Medicine::orderBy('name', 'asc')->get();
        $procurements = Procurement::with('medicine')->orderBy('id', 'desc')->get();
        
        return view('medicines.pengadaan', compact('medicines', 'procurements'));
    }

    // Store Invoice Modal
    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:100',
            'invoice_date' => 'required|date',
            'supplier_name' => 'required|string|max:255',
        ]);

        $firstMed = Medicine::first();

        Procurement::create([
            'medicine_id' => $firstMed->id ?? 1,
            'supplier_name' => $validated['supplier_name'],
            'invoice_number' => $validated['invoice_number'],
            'order_date' => $validated['invoice_date'],
            'quantity' => 10,
            'status' => 'Received',
            'receive_date' => $validated['invoice_date']
        ]);

        return redirect()->route('medicines.pengadaan')->with('success', "No. Faktur {$validated['invoice_number']} dari {$validated['supplier_name']} berhasil disimpan!");
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

    // 3. Stok Kampus
    public function stokKampus(Request $request)
    {
        $campuses = [
            ['name' => 'Kebayoran Baru', 'count' => 194],
            ['name' => 'Pejaten', 'count' => 71],
            ['name' => 'Bintaro', 'count' => 60],
            ['name' => 'Sentra Primer', 'count' => 91],
            ['name' => 'Cikarang', 'count' => 86],
        ];

        $selectedCampus = $request->query('campus');
        $medicines = Medicine::orderBy('name', 'asc')->get();

        return view('medicines.stok_kampus', compact('campuses', 'selectedCampus', 'medicines'));
    }

    // 4. Permohonan Stok (Multi-branch Request & Acceptance Flow)
    public function permohonanStok(Request $request)
    {
        // Session-based requests store for interactive testing
        $defaultRequests = [
            [
                'id' => 101,
                'campus_name' => 'Kebayoran Baru',
                'medicine_name' => 'PARACETAMOL 500MG TABLET',
                'qty' => 50,
                'requester' => 'Admin Kebayoran',
                'date' => now()->subDays(1)->format('d M Y'),
                'status' => session('status_101', 'Pending'),
            ],
            [
                'id' => 102,
                'campus_name' => 'Bintaro',
                'medicine_name' => 'AMOXICILLIN TRIHYDRATE 500MG',
                'qty' => 30,
                'requester' => 'Admin Bintaro',
                'date' => now()->subDays(2)->format('d M Y'),
                'status' => session('status_102', 'Disetujui'),
            ],
            [
                'id' => 103,
                'campus_name' => 'Pejaten',
                'medicine_name' => 'VENTOLIN INHALER 100MCG',
                'qty' => 20,
                'requester' => 'Admin Pejaten',
                'date' => now()->subDays(3)->format('d M Y'),
                'status' => session('status_103', 'Disetujui'),
            ],
        ];

        $medicines = Medicine::orderBy('name', 'asc')->get();

        return view('medicines.permohonan_stok', compact('defaultRequests', 'medicines'));
    }

    // Store new stock request
    public function storeStockRequest(Request $request)
    {
        $validated = $request->validate([
            'campus_name' => 'required|string',
            'medicine_name' => 'required|string',
            'qty' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        return redirect()->route('mock.permohonan_stok')->with('success', "Permohonan stok {$validated['medicine_name']} ({$validated['qty']} Unit) dari Kampus {$validated['campus_name']} berhasil diajukan!");
    }

    // Update Acceptance status (Super Admin Approve / Reject)
    public function updateRequestStatus(Request $request, $id)
    {
        $status = $request->input('status');
        if (in_array($status, ['Disetujui', 'Ditolak'])) {
            session(["status_{$id}" => $status]);
        }

        $message = $status === 'Disetujui' 
            ? "Permohonan stok obat berhasil DISETUJUI oleh Super Admin Pusat dan dikirim ke cabang!" 
            : "Permohonan stok obat telah DITOLAK oleh Super Admin Pusat.";

        return redirect()->route('mock.permohonan_stok')->with('success', $message);
    }
}

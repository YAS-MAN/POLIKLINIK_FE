@extends('layouts.app')

@section('title', 'Pengadaan Obat Apotek | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <span>Apotek & Logistik</span>
        <span>/</span>
        <span class="breadcrumb-item active">Pengadaan Obat</span>
    </div>
</div>

<!-- STOCKS WARNING FOR PROCUREMENT -->
@if($lowStockMedicines->count() > 0)
<div class="stock-warning-box" style="margin-bottom: 24px;">
    <div class="stock-warning-icon">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--warning);">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
        </svg>
    </div>
    <div class="stock-warning-info">
        <h5>Kebutuhan Stok Obat Terdeteksi!</h5>
        <p>Ada {{ $lowStockMedicines->count() }} obat yang berada di bawah stok minimum. Silakan gunakan formulir di bawah untuk mengajukan usulan pengadaan.</p>
    </div>
</div>
@endif

<!-- MAIN SEC: PROCUREMENT FORM & TRANSACTIONS TABLE -->
<div class="grid-2">
    <!-- Left Column: Transactions History -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="card-title-bar" style="padding: 24px 24px 10px 24px;">
            <h3 class="card-title">Riwayat Transaksi Pengadaan</h3>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Detail Obat</th>
                        <th>Supplier / Penyedia</th>
                        <th>Qty</th>
                        <th>Tanggal Order</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($procurements as $proc)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: var(--primary-color);">{{ $proc->medicine->name }}</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Harga Beli: Rp {{ number_format($proc->medicine->purchase_price, 0, ',', '.') }}</div>
                        </td>
                        <td>{{ $proc->supplier_name }}</td>
                        <td style="font-weight: 700;">{{ $proc->quantity }} {{ $proc->medicine->formulation }}</td>
                        <td>{{ \Carbon\Carbon::parse($proc->order_date)->format('d M Y') }}</td>
                        <td>
                            @if($proc->status === 'Proposed')
                                <span class="status-pill" style="background-color: #e0f2fe; color: #0369a1; padding: 3px 8px;">Diusulkan</span>
                            @elseif($proc->status === 'Approved')
                                <span class="status-pill" style="background-color: #fef3c7; color: #d97706; padding: 3px 8px;">Disetujui</span>
                            @else
                                <span class="status-pill available" style="padding: 3px 8px;">Diterima</span>
                            @endif
                        </td>
                        <td>
                            @if($proc->status === 'Proposed')
                                <form action="{{ route('medicines.update_procurement_status', $proc->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="Approved">
                                    <button type="submit" class="btn-primary" style="padding: 6px 12px; font-size: 11px; box-shadow: none;">Setujui</button>
                                </form>
                            @elseif($proc->status === 'Approved')
                                <form action="{{ route('medicines.update_procurement_status', $proc->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="Received">
                                    <button type="submit" class="btn-primary" style="padding: 6px 12px; font-size: 11px; background-color: var(--primary-color); box-shadow: none;">Terima Barang</button>
                                </form>
                            @else
                                <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">Diterima pada {{ \Carbon\Carbon::parse($proc->receive_date)->format('d/m/Y') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada riwayat transaksi pengadaan obat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Column: Proposed Procurements Form -->
    <div class="card" style="align-self: flex-start;">
        <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 10px; margin-bottom: 15px;">
            <h3 class="card-title" style="font-size: 16px;">Ajukan Usulan Pengadaan Obat</h3>
        </div>
        
        <form action="{{ route('medicines.store_procurement') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="medicine_id">Pilih Obat Yang Dibutuhkan <span style="color: var(--danger);">*</span></label>
                <select id="medicine_id" name="medicine_id" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($medicines as $med)
                        <option value="{{ $med->id }}">
                            {{ $med->name }} (Sisa Stok: {{ $med->stock }} | Batas Min: {{ $med->min_stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="supplier_name">Nama Supplier / Penyedia <span style="color: var(--danger);">*</span></label>
                <input type="text" id="supplier_name" name="supplier_name" required placeholder="Contoh: PT Kimia Farma Tbk">
            </div>

            <div class="form-group">
                <label for="quantity">Jumlah Unit Pengadaan <span style="color: var(--danger);">*</span></label>
                <input type="number" id="quantity" name="quantity" required min="1" placeholder="Contoh: 100">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                Kirim Usulan Pengadaan
            </button>
        </form>
    </div>
</div>
@endsection

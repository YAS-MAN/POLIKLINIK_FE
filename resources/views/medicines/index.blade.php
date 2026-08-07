@extends('layouts.app')

@section('title', 'Inventaris Obat Apotek | Poliklinik Al-Azhar')

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
        <span class="breadcrumb-item active">Inventaris Obat</span>
    </div>
</div>

<!-- WARNING WIDGETS -->
@if($lowStockMedicines->count() > 0 || $expiringMedicines->count() > 0)
<div class="grid-2" style="margin-bottom: 24px; grid-template-columns: 1fr 1fr;">
    <!-- Low Stock Alert -->
    @if($lowStockMedicines->count() > 0)
    <div class="stock-warning-box" style="margin-bottom: 0;">
        <div class="stock-warning-icon">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--warning);">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="stock-warning-info">
            <h5>Peringatan Stok Minimum Obat!</h5>
            <p>Ada {{ $lowStockMedicines->count() }} obat di bawah batas aman. Segera lakukan pengadaan baru:</p>
            <ul style="margin-top: 6px; padding-left: 20px; font-size: 11.5px; color: #92400e;">
                @foreach($lowStockMedicines as $lowMed)
                    <li><strong>{{ $lowMed->name }}</strong> (Sisa: {{ $lowMed->stock }} {{ $lowMed->formulation }}, Batas Min: {{ $lowMed->min_stock }})</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Expiration Alert -->
    @if($expiringMedicines->count() > 0)
    <div class="stock-warning-box" style="background-color: #fdf2f2; border-color: #fde8e8; margin-bottom: 0;">
        <div class="stock-warning-icon">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--danger);">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.8 2.8a1 1 0 101.414-1.414L11 9.586V6z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="stock-warning-info" style="color: #991b1b">
            <h5 style="color: #991b1b">Peringatan Obat Mendekati Kadaluarsa!</h5>
            <p style="color: #b91c1c">Ada {{ $expiringMedicines->count() }} obat yang kadaluarsa dalam waktu kurang dari 6 bulan:</p>
            <ul style="margin-top: 6px; padding-left: 20px; font-size: 11.5px; color: #b91c1c;">
                @foreach($expiringMedicines as $expMed)
                    <li><strong>{{ $expMed->name }}</strong> (Kadaluarsa: {{ \Carbon\Carbon::parse($expMed->expire_date)->format('d M Y') }})</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
@endif

<!-- INVENTORY TABLE CARD -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div class="card-title-bar" style="padding: 24px 24px 10px 24px;">
        <h3 class="card-title">Stok Inventaris Obat Apotek</h3>
    </div>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Golongan / Kategori</th>
                    <th>Bentuk Sediaan</th>
                    <th>Aturan Pakai Standar</th>
                    <th>Jumlah Stok</th>
                    <th>Harga Beli Satuan</th>
                    <th>Tanggal Kadaluarsa</th>
                    <th>Status Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $med)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: var(--primary-color);">{{ $med->name }}</div>
                        <div style="font-size: 11px; color: var(--text-muted);">Nama Generik: {{ $med->generic_name ?? '-' }}</div>
                    </td>
                    <td>{{ $med->category }}</td>
                    <td>{{ $med->formulation }}</td>
                    <td style="font-style: italic;">{{ $med->dosage_rule ?? '-' }}</td>
                    <td style="font-weight: 700; color: {{ $med->stock <= $med->min_stock ? 'var(--danger)' : 'var(--text-color)' }};">
                        {{ $med->stock }} {{ $med->formulation }}
                    </td>
                    <td>Rp {{ number_format($med->purchase_price, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($med->expire_date)->format('d F Y') }}</td>
                    <td>
                        @if($med->stock == 0)
                            <span class="status-pill not-available" style="padding: 3px 6px;">Habis</span>
                        @elseif($med->stock <= $med->min_stock)
                            <span class="status-pill" style="background-color: #fef3c7; color: #d97706; padding: 3px 6px;">Menipis</span>
                        @else
                            <span class="status-pill available" style="padding: 3px 6px;">Aman</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

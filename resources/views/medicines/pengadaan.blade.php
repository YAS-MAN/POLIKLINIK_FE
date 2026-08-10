@extends('layouts.app')

@section('title', 'Transaksi Pembelian Obat | Poliklinik Al-Azhar')

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
        <span class="breadcrumb-item active">Transaksi Pembelian</span>
    </div>
</div>

<!-- TOP BUTTON (NO EMOJIS - CLEAN SOLID ICON) -->
<div style="margin-bottom: 20px;">
    <button type="button" class="btn-primary" onclick="openInvoiceModal()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px;">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
        <span>input No.Faktur</span>
    </button>
</div>

<!-- TRANSAKSI PEMBELIAN TABLE CARD -->
<div class="card" style="padding: 20px; border-radius: 16px;">
    @if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 16px;">
        {{ session('success') }}
    </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569;">
            <span>Show</span>
            <select style="padding: 6px 12px; border-radius: 8px; border: 1.5px solid #cbd5e1;">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
            <span>entries</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569;">
            <span>Search:</span>
            <input type="text" placeholder="Cari no faktur / supplier..." style="padding: 6px 14px; border-radius: 8px; border: 1.5px solid #cbd5e1; width: 220px;">
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background-color: #ffffff; color: #1e293b; border-bottom: 2px solid #e2e8f0;">
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 40px;">#</th>
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 140px;">Aksi</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">No. Faktur</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Tanggal</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Supplier</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Jml Item</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Grand Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $mockInvoices = [
                        ['no' => '037/SSF/1/2026', 'date' => '2026-01-05', 'supplier' => 'APOTIK SENOPATI', 'items' => 6, 'total' => 1175470],
                        ['no' => '4760100864', 'date' => '2026-01-08', 'supplier' => 'APOTIK SENOPATI', 'items' => 8, 'total' => 3338500],
                        ['no' => '37/1/MBS/2026', 'date' => '2026-01-07', 'supplier' => 'PT. MULYA BUDISARI', 'items' => 8, 'total' => 4527690],
                        ['no' => '0067/SJ-BHF/1/26', 'date' => '2026-01-05', 'supplier' => 'BERKAH HEXA FARMACIA', 'items' => 18, 'total' => 1888158],
                        ['no' => '00117/SJ-BHF/1/26', 'date' => '2026-01-05', 'supplier' => 'BERKAH HEXA FARMACIA', 'items' => 2, 'total' => 222657],
                        ['no' => '0068/SJ-BHF/1/26', 'date' => '2026-01-05', 'supplier' => 'BERKAH HEXA FARMACIA', 'items' => 2, 'total' => 383488],
                        ['no' => '037/SSF/1/2026', 'date' => '2026-01-05', 'supplier' => 'APOTIK SENOPATI', 'items' => 6, 'total' => 667500],
                        ['no' => '662796', 'date' => '2026-01-05', 'supplier' => 'APOTIK JATI', 'items' => 8, 'total' => 1913165],
                        ['no' => '662801', 'date' => '2026-01-05', 'supplier' => 'APOTIK JATI', 'items' => 14, 'total' => 4076724],
                        ['no' => '644599', 'date' => '2025-01-06', 'supplier' => 'APOTIK JATI', 'items' => 6, 'total' => 1475190],
                    ];
                @endphp

                @foreach($mockInvoices as $index => $inv)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <!-- Edit Solid SVG Button -->
                            <button type="button" class="btn-icon view" style="width: 32px; height: 32px; border-radius: 50%; background-color: #3182ce; display: flex; align-items: center; justify-content: center;" title="Edit Faktur">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                            </button>
                            <!-- Detail Solid SVG Button -->
                            <button type="button" class="btn-icon view" style="width: 32px; height: 32px; border-radius: 50%; background-color: #3182ce; display: flex; align-items: center; justify-content: center;" title="Detail Item">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                            </button>
                            <!-- Print Solid SVG Button -->
                            <button type="button" class="btn-icon view" onclick="window.print()" style="width: 32px; height: 32px; border-radius: 50%; background-color: #3182ce; display: flex; align-items: center; justify-content: center;" title="Cetak Faktur">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                    </td>
                    <td style="font-weight: 600;">{{ $inv['no'] }}</td>
                    <td>{{ $inv['date'] }}</td>
                    <td>{{ $inv['supplier'] }}</td>
                    <td>{{ $inv['items'] }}</td>
                    <td style="font-weight: 700;">{{ number_format($inv['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- UPGRADED CUSTOM POP-UP MODAL INPUT NO. FAKTUR (CUSTOM SLATE INDIGO DESIGN SYSTEM) -->
<div id="invoiceModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36, 38, 58, 0.5); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div class="modal-content" style="width: 500px; max-width: 92vw; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(56, 59, 87, 0.25); padding: 0;">
        <div style="background: linear-gradient(135deg, #383B57, #4F58BA); color: #ffffff; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 17px; font-weight: 700; color: #ffffff; margin: 0;">Input No. Faktur Pembelian</h3>
            <button type="button" onclick="closeInvoiceModal()" style="background: rgba(255,255,255,0.15); border: none; font-size: 20px; cursor: pointer; color: #ffffff; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form action="{{ route('medicines.store_invoice') }}" method="POST" style="padding: 24px;">
            @csrf
            
            <div class="form-group">
                <label>No. Faktur Pembelian</label>
                <input type="text" name="invoice_number" placeholder="Contoh: 037/SSF/1/2026" required>
            </div>

            <div class="form-group">
                <label>Tanggal Faktur</label>
                <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label>Supplier / Apotik Penyedia</label>
                <input type="text" name="supplier_name" placeholder="Nama Apotik / PBF Supplier" required>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #e2e8f0; padding-top: 18px;">
                <button type="button" onclick="closeInvoiceModal()" class="btn-outline" style="padding: 10px 20px;">
                    Batal
                </button>
                <button type="submit" class="btn-primary" style="padding: 10px 22px;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 00-1.414-1.414L10 11.586l-2.293-2.293z"></path></svg>
                    <span>Simpan Faktur</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openInvoiceModal() {
        document.getElementById('invoiceModal').style.display = 'flex';
    }

    function closeInvoiceModal() {
        document.getElementById('invoiceModal').style.display = 'none';
    }
</script>
@endsection

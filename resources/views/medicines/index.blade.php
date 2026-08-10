@extends('layouts.app')

@section('title', 'Data Obat & Inventaris | Poliklinik Al-Azhar')

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
        <span class="breadcrumb-item active">Data Obat</span>
    </div>
</div>

<!-- TOP ACTION BUTTONS BAR (NO EMOJIS - CLEAN SOLID ICONS) -->
<div style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
    <button type="button" class="btn-primary" onclick="openMedicineModal()" style="background-color: #3182ce; border-radius: 8px; padding: 10px 18px; font-size: 13.5px; display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
        <span>Tambah Data Obat</span>
    </button>

    <button type="button" class="btn-primary" onclick="printMedicineReport()" style="background-color: #3182ce; border-radius: 8px; padding: 10px 18px; font-size: 13.5px; display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path></svg>
        <span>Print Laporan</span>
    </button>

    <button type="button" class="btn-primary" onclick="exportMedicineToExcel()" style="background-color: #3182ce; border-radius: 8px; padding: 10px 18px; font-size: 13.5px; display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span>Unduh Dalam Format Excel</span>
    </button>
</div>

<!-- DATA OBAT TABLE CARD -->
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
            <input type="text" id="medicineSearchInput" onkeyup="filterMedicineTable()" placeholder="Cari nama obat..." style="padding: 6px 14px; border-radius: 8px; border: 1.5px solid #cbd5e1; width: 220px;">
        </div>
    </div>

    <div class="table-responsive">
        <table id="medicineDataTable">
            <thead>
                <tr style="background-color: #ffffff; color: #1e293b; border-bottom: 2px solid #e2e8f0;">
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 40px;">#</th>
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 110px;">Aksi</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Nama Obat</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Kemasan</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Kadaluarsa</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Satuan</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Harga</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Stok</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Stok Limit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $index => $med)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <!-- Solid SVG Edit Button -->
                            <button type="button" class="btn-icon view" onclick="editMedicine({{ json_encode($med) }})" title="Edit Data Obat" style="width: 32px; height: 32px; border-radius: 50%; background-color: #3182ce; display: flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                            </button>
                            <!-- Solid SVG Delete Button -->
                            <form action="{{ route('medicines.destroy_medicine', $med->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data obat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Hapus Data Obat" style="width: 32px; height: 32px; border-radius: 50%; background-color: #e53e3e; display: flex; align-items: center; justify-content: center;">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                </button>
                            </form>
                            @if(isset($med->is_active) && !$med->is_active)
                                <span style="background-color: #38bdf8; color: #ffffff; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 20px; white-space: nowrap;">Tidak Digunakan</span>
                            @endif
                        </div>
                    </td>
                    <td style="font-weight: 600;">{{ strtoupper($med->name) }}</td>
                    <td>{{ $med->package ?? 'botol' }}</td>
                    <td>{{ $med->expire_date ? \Carbon\Carbon::parse($med->expire_date)->format('Y-m-d') : '2028-12-31' }}</td>
                    <td>{{ $med->formulation ?? 'Botol' }}</td>
                    <td>{{ number_format($med->purchase_price, 0, ',', '.') }}</td>
                    <td style="font-weight: 700;">{{ $med->stock }}</td>
                    <td>{{ $med->min_stock ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--text-muted);">Belum ada data obat terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- UPGRADED CUSTOM MODAL FORM TAMBAH / EDIT DATA OBAT (CUSTOM SLATE INDIGO DESIGN SYSTEM) -->
<div id="medicineModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36, 38, 58, 0.5); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div class="modal-content" style="width: 540px; max-width: 92vw; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(56, 59, 87, 0.25); padding: 0;">
        <div style="background: linear-gradient(135deg, #383B57, #4F58BA); color: #ffffff; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
            <h3 id="modalTitle" style="font-size: 17px; font-weight: 700; color: #ffffff; margin: 0;">Data Obat</h3>
            <button type="button" onclick="closeMedicineModal()" style="background: rgba(255,255,255,0.15); border: none; font-size: 20px; cursor: pointer; color: #ffffff; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form id="medicineForm" action="{{ route('medicines.store_medicine') }}" method="POST" style="padding: 24px;">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="form-group">
                <label>Nama Obat</label>
                <input type="text" id="medName" name="name" placeholder="Contoh: ERLAMYCETIN TTS MATA" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kemasan</label>
                    <input type="text" id="medPackage" name="package" placeholder="botol / box / strip">
                </div>
                <div class="form-group">
                    <label>Kadaluarsa</label>
                    <input type="date" id="medExpire" name="expire_date" value="2030-01-01">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Harga Obat (Rp)</label>
                    <input type="number" id="medPrice" name="purchase_price" placeholder="20500">
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <select id="medUnit" name="unit">
                        <option value="Botol">Botol</option>
                        <option value="Box">Box</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Strip">Strip</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Ampul">Ampul</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" id="medStock" name="stock" value="1" required>
                </div>
                <div class="form-group">
                    <label>Re-order (Limit Minimum)</label>
                    <input type="number" id="medMinStock" name="min_stock" value="0">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label>Status Penggunaan</label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 500; margin-top: 4px;">
                    <input type="checkbox" id="medStatus" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: var(--primary-color);">
                    <span>Digunakan Dalam Layanan Medis</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #e2e8f0; padding-top: 18px;">
                <button type="button" onclick="closeMedicineModal()" class="btn-outline" style="padding: 10px 20px;">
                    Batal
                </button>
                <button type="submit" class="btn-primary" style="padding: 10px 22px;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 00-1.414-1.414L10 11.586l-2.293-2.293z"></path></svg>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- FORMAL REPORT PRINTABLE AREA (HIDDEN FROM WEB VIEW, SHOWN ON PRINT) -->
<div id="printableMedicineReport" style="display: none;">
    <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 800; text-transform: uppercase;">POLIKLINIK AL-AZHAR</h2>
        <p style="font-size: 13px;">Laporan Resmi Inventaris & Data Obat Apotek</p>
        <p style="font-size: 11px; color: #555;">Dicetak Tanggal: {{ date('d F Y H:i') }} WIB | Oleh: Administrator Medis</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 12px;" border="1">
        <thead>
            <tr style="background-color: #f1f5f9;">
                <th style="padding: 8px;">No</th>
                <th style="padding: 8px;">Nama Obat</th>
                <th style="padding: 8px;">Kemasan</th>
                <th style="padding: 8px;">Kadaluarsa</th>
                <th style="padding: 8px;">Satuan</th>
                <th style="padding: 8px;">Harga (Rp)</th>
                <th style="padding: 8px;">Stok</th>
                <th style="padding: 8px;">Stok Limit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $idx => $m)
            <tr>
                <td style="padding: 8px; text-align: center;">{{ $idx + 1 }}</td>
                <td style="padding: 8px; font-weight: 600;">{{ strtoupper($m->name) }}</td>
                <td style="padding: 8px;">{{ $m->package ?? 'botol' }}</td>
                <td style="padding: 8px;">{{ $m->expire_date ? \Carbon\Carbon::parse($m->expire_date)->format('d/m/Y') : '31/12/2028' }}</td>
                <td style="padding: 8px;">{{ $m->formulation ?? 'Botol' }}</td>
                <td style="padding: 8px; text-align: right;">{{ number_format($m->purchase_price, 0, ',', '.') }}</td>
                <td style="padding: 8px; text-align: center; font-weight: 700;">{{ $m->stock }}</td>
                <td style="padding: 8px; text-align: center;">{{ $m->min_stock ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Real Excel Exporter JS
    function exportMedicineToExcel() {
        let table = document.getElementById("medicineDataTable");
        let rows = table.querySelectorAll("tr");
        let csv = [];
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                if (j === 1) continue; // Skip Action column for clean Excel export
                let text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                row.push('"' + text.replace(/"/g, '""') + '"');
            }
            csv.push(row.join(","));
        }
        let csvFile = new Blob([csv.join("\n")], {type: "text/csv;charset=utf-8;"});
        let downloadLink = document.createElement("a");
        downloadLink.download = "Laporan_Data_Obat_Poliklinik_AlAzhar_" + new Date().toISOString().slice(0,10) + ".csv";
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    // Clean Print Report
    function printMedicineReport() {
        window.print();
    }

    // Search filter
    function filterMedicineTable() {
        let input = document.getElementById("medicineSearchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("medicineDataTable");
        let tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
            let tdName = tr[i].getElementsByTagName("td")[2];
            if (tdName) {
                let txtValue = tdName.textContent || tdName.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }

    function openMedicineModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Data Obat';
        document.getElementById('medicineForm').action = "{{ route('medicines.store_medicine') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('medName').value = '';
        document.getElementById('medPackage').value = '';
        document.getElementById('medExpire').value = '2030-01-01';
        document.getElementById('medPrice').value = '';
        document.getElementById('medStock').value = '1';
        document.getElementById('medMinStock').value = '0';
        document.getElementById('medStatus').checked = true;
        document.getElementById('medicineModal').style.display = 'flex';
    }

    function editMedicine(med) {
        document.getElementById('modalTitle').innerText = 'Edit Data Obat';
        document.getElementById('medicineForm').action = "/obat/" + med.id;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('medName').value = med.name || '';
        document.getElementById('medPackage').value = med.package || 'botol';
        document.getElementById('medExpire').value = med.expire_date || '2030-01-01';
        document.getElementById('medPrice').value = med.purchase_price || 20500;
        document.getElementById('medStock').value = med.stock || 1;
        document.getElementById('medMinStock').value = med.min_stock || 0;
        document.getElementById('medStatus').checked = med.is_active != 0;
        document.getElementById('medicineModal').style.display = 'flex';
    }

    function closeMedicineModal() {
        document.getElementById('medicineModal').style.display = 'none';
    }
</script>
@endsection

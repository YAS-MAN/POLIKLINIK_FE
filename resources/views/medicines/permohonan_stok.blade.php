@extends('layouts.app')

@section('title', 'Permohonan Stok Obat | Poliklinik Al-Azhar')

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
        <span class="breadcrumb-item active">Permohonan Stok Cabang</span>
    </div>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h2 style="font-size: 20px; font-weight: 700;">Permohonan Stok Obat Cabang Kampus</h2>
        <p style="font-size: 13.5px; color: var(--text-muted);">Alur verifikasi & persetujuan (Acceptance) permohonan pasokan obat dari Admin Cabang oleh Super Admin Pusat</p>
    </div>
    
    <!-- Real Modal Form Trigger Button -->
    <button type="button" class="btn-primary" onclick="openPermohonanModal()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px;">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
        <span>+ Buat Permohonan Stok Cabang</span>
    </button>
</div>

<div class="card" style="padding: 20px; border-radius: 16px;">
    @if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 16px;">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background-color: #ffffff; color: #1e293b; border-bottom: 2px solid #e2e8f0;">
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 40px;">#</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Asal Kampus</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Nama Obat</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Jumlah Usulan</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Pengaju (Admin Cabang)</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Tanggal</th>
                    <th style="background: none; color: #1e293b; font-weight: 700; min-width: 170px;">Status Verifikasi</th>
                    <th style="background: none; color: #1e293b; font-weight: 700; min-width: 220px;">Aksi Acceptance (Super Admin)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($defaultRequests as $index => $req)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 700; color: var(--primary-color);">{{ $req['campus_name'] }}</td>
                    <td style="font-weight: 600;">{{ $req['medicine_name'] }}</td>
                    <td>{{ $req['qty'] }} Unit</td>
                    <td>{{ $req['requester'] }}</td>
                    <td>{{ $req['date'] }}</td>
                    <td>
                        <!-- STRAIGHT SINGLE LINE BADGE -->
                        @if($req['status'] === 'Disetujui')
                            <span style="background-color: var(--primary-light); color: var(--primary-color); font-weight: 700; font-size: 11.5px; padding: 6px 14px; border-radius: 20px; white-space: nowrap; display: inline-block;">
                                Disetujui Pusat
                            </span>
                        @elseif($req['status'] === 'Pending')
                            <span style="background-color: #fef3c7; color: #d97706; font-weight: 700; font-size: 11.5px; padding: 6px 14px; border-radius: 20px; white-space: nowrap; display: inline-block;">
                                Menunggu Approval
                            </span>
                        @else
                            <span style="background-color: #fdf2f2; color: var(--danger); font-weight: 700; font-size: 11.5px; padding: 6px 14px; border-radius: 20px; white-space: nowrap; display: inline-block;">
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($req['status'] === 'Pending')
                        <div style="display: flex; gap: 8px;">
                            <!-- Real Acceptance Form -->
                            <form action="{{ route('medicines.update_request_status', $req['id']) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Disetujui">
                                <button type="submit" style="background-color: #10b981; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span>Setujui (Accept)</span>
                                </button>
                            </form>

                            <!-- Real Reject Form -->
                            <form action="{{ route('medicines.update_request_status', $req['id']) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Ditolak">
                                <button type="submit" style="background-color: #ef4444; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    <span>Tolak</span>
                                </button>
                            </form>
                        </div>
                        @else
                            <span style="font-size: 12px; color: var(--text-muted); font-style: italic;">Selesai Diproses</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- REAL MODAL FORM BUAT PERMOHONAN STOK CABANG -->
<div id="permohonanModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36, 38, 58, 0.5); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div class="modal-content" style="width: 520px; max-width: 92vw; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(56, 59, 87, 0.25); padding: 0;">
        <div style="background: linear-gradient(135deg, #383B57, #4F58BA); color: #ffffff; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 17px; font-weight: 700; color: #ffffff; margin: 0;">Permohonan Pasokan Stok Cabang</h3>
            <button type="button" onclick="closePermohonanModal()" style="background: rgba(255,255,255,0.15); border: none; font-size: 20px; cursor: pointer; color: #ffffff; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form action="{{ route('medicines.store_stock_request') }}" method="POST" style="padding: 24px;">
            @csrf
            
            <div class="form-group">
                <label>Asal Kampus Cabang</label>
                <select name="campus_name" required>
                    <option value="Kebayoran Baru">Kebayoran Baru</option>
                    <option value="Pejaten">Pejaten</option>
                    <option value="Bintaro">Bintaro</option>
                    <option value="Sentra Primer">Sentra Primer</option>
                    <option value="Cikarang">Cikarang</option>
                </select>
            </div>

            <div class="form-group">
                <label>Pilih Jenis Obat</label>
                <select name="medicine_name" required>
                    @foreach($medicines as $m)
                        <option value="{{ $m->name }}">{{ strtoupper($m->name) }} (Stok Gudang: {{ $m->stock }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Usulan Pasokan (Qty)</label>
                <input type="number" name="qty" value="50" min="1" required placeholder="Masukkan jumlah unit obat...">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label>Catatan / Keterangan Kebutuhan</label>
                <textarea name="notes" rows="3" placeholder="Alasan kebutuhan permohonan stok obat cabang..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #e2e8f0; padding-top: 18px;">
                <button type="button" onclick="closePermohonanModal()" class="btn-outline" style="padding: 10px 20px;">
                    Batal
                </button>
                <button type="submit" class="btn-primary" style="padding: 10px 22px;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                    <span>Kirim Permohonan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPermohonanModal() {
        document.getElementById('permohonanModal').style.display = 'flex';
    }

    function closePermohonanModal() {
        document.getElementById('permohonanModal').style.display = 'none';
    }
</script>
@endsection

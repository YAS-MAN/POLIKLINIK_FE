@extends('layouts.app')

@section('title', 'Manajemen Poli & Layanan | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <span>Data Poliklinik</span>
        <span>/</span>
        <span class="breadcrumb-item active">Poli & Layanan</span>
    </div>
    
    <button class="btn-primary" onclick="toggleModal('poliModal', true)" style="display: flex; align-items: center; gap: 6px;">
        <!-- Plus Icon -->
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
        </svg>
        <span>Tambah Poli Baru</span>
    </button>
</div>

<!-- POLI TABLE CARD -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div class="card-title-bar" style="padding: 24px 24px 10px 24px; border-bottom: 1px solid var(--border-color); margin-bottom: 0;">
        <h3 class="card-title">Daftar Poliklinik & Tarif Layanan Dasar</h3>
    </div>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Poliklinik</th>
                    <th>Kode Poli</th>
                    <th>Tarif Layanan Dasar</th>
                    <th>Tanggal Input</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($polis as $index => $poli)
                <tr>
                    <td>{{ sprintf('%02d', $index + 1) }}</td>
                    <td style="font-weight: 600; color: var(--primary-color);">{{ $poli->name }}</td>
                    <td style="font-family: monospace; font-weight: 700;">{{ $poli->code }}</td>
                    <td style="font-weight: 700;">Rp {{ number_format($poli->base_tariff, 0, ',', '.') }}</td>
                    <td>{{ $poli->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <!-- Edit Button -->
                            <button onclick="toggleModal('editPoli_{{ $poli->id }}', true)" class="btn-icon edit" title="Edit Poli & Tarif" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.829z"></path>
                                </svg>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('poli.destroy', $poli->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Poli {{ $poli->name }}? Semua data transaksi dan nakes terkait poli ini mungkin akan terpengaruh.');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Hapus Poli" style="display: inline-flex; align-items: center; justify-content: center;">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- MODAL EDIT POLI -->
                        <div id="editPoli_{{ $poli->id }}" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(44, 62, 43, 0.4); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;">
                            <div class="card" style="width: 100%; max-width: 500px; text-align: left;">
                                <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                                    <h3 class="card-title">Edit Data Poliklinik</h3>
                                    <button type="button" onclick="toggleModal('editPoli_{{ $poli->id }}', false)" style="background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer;">✕</button>
                                </div>
                                
                                <form action="{{ route('poli.update', $poli->id) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group">
                                        <label for="name_{{ $poli->id }}">Nama Poliklinik <span style="color: var(--danger);">*</span></label>
                                        <input type="text" id="name_{{ $poli->id }}" name="name" value="{{ $poli->name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="code_{{ $poli->id }}">Kode Poli (Singkatan) <span style="color: var(--danger);">*</span></label>
                                        <input type="text" id="code_{{ $poli->id }}" name="code" value="{{ $poli->code }}" required style="text-transform: uppercase;">
                                    </div>

                                    <div class="form-group">
                                        <label for="tariff_{{ $poli->id }}">Tarif Layanan Dasar (Rp) <span style="color: var(--danger);">*</span></label>
                                        <input type="number" id="tariff_{{ $poli->id }}" name="base_tariff" value="{{ intval($poli->base_tariff) }}" required min="0">
                                    </div>

                                    <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
                                        <button type="button" class="btn-outline" onclick="toggleModal('editPoli_{{ $poli->id }}', false)">Batal</button>
                                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Tidak ada data poliklinik terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL ADD POLI -->
<div id="poliModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(44, 62, 43, 0.4); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 500px; animation: slideDown 0.3s ease;">
        <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
            <h3 class="card-title">Tambah Poliklinik Baru</h3>
            <button onclick="toggleModal('poliModal', false)" style="background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer;">✕</button>
        </div>
        
        <form action="{{ route('poli.store') }}" method="POST" style="margin-top: 15px;">
            @csrf
            
            <div class="form-group">
                <label for="add_name">Nama Poliklinik <span style="color: var(--danger);">*</span></label>
                <input type="text" id="add_name" name="name" required placeholder="Contoh: Poli Spesialis Anak">
            </div>

            <div class="form-group">
                <label for="add_code">Kode Poli (Maks 5 Karakter) <span style="color: var(--danger);">*</span></label>
                <input type="text" id="add_code" name="code" required maxlength="5" placeholder="Contoh: PSA" style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label for="add_tariff">Tarif Layanan Dasar (Rp) <span style="color: var(--danger);">*</span></label>
                <input type="number" id="add_tariff" name="base_tariff" required min="0" placeholder="Contoh: 90000">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
                <button type="button" class="btn-outline" onclick="toggleModal('poliModal', false)">Batal</button>
                <button type="submit" class="btn-primary">Tambah Poli</button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(44, 62, 43, 0.4);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    @keyframes slideDown {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
@endsection

@section('scripts')
<script>
    function toggleModal(modalId, show) {
        const modal = document.getElementById(modalId);
        if (show) {
            modal.style.display = 'flex';
        } else {
            modal.style.display = 'none';
        }
    }
</script>
@endsection

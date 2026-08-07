@extends('layouts.app')

@section('title', 'Manajemen Tenaga Kesehatan | Poliklinik Al-Azhar')

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
        <span class="breadcrumb-item active">Tenaga Kesehatan</span>
    </div>
    
    <button class="btn-primary" onclick="toggleModal('doctorModal', true)" style="display: flex; align-items: center; gap: 6px;">
        <!-- User Add Icon -->
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
        </svg>
        <span>Tambah Tenaga Kesehatan</span>
    </button>
</div>

<!-- DOCTORS TABLE CARD -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div class="card-title-bar" style="padding: 24px 24px 10px 24px; border-bottom: 1px solid var(--border-color); margin-bottom: 0;">
        <h3 class="card-title">Daftar Tenaga Kesehatan (Dokter & Nakes)</h3>
    </div>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Dokter</th>
                    <th>Spesialisasi</th>
                    <th>Departemen Poli</th>
                    <th>Status Praktik</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $index => $doc)
                <tr>
                    <td>{{ sprintf('%02d', $index + 1) }}</td>
                    <td>
                        <div class="patient-table-name">
                            <div class="patient-table-avatar" style="background-color: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 11px;">
                                {{ strtoupper(substr($doc->name, 4, 2)) }}
                            </div>
                            <span>{{ $doc->name }}</span>
                        </div>
                    </td>
                    <td>{{ $doc->specialty }}</td>
                    <td>{{ $doc->department }}</td>
                    <td>
                        <form action="{{ route('nakes.toggle_status', $doc->id) }}" method="POST" id="statusForm_{{ $doc->id }}" style="margin: 0; display: inline-block;">
                            @csrf
                            <label class="switch" title="Ubah Status Praktik">
                                <input type="checkbox" name="status" {{ $doc->status === 'Available' ? 'checked' : '' }} onchange="document.getElementById('statusForm_{{ $doc->id }}').submit()">
                                <span class="slider round"></span>
                            </label>
                        </form>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <!-- Edit Button -->
                            <button onclick="toggleModal('editDoctor_{{ $doc->id }}', true)" class="btn-icon edit" title="Edit Data Nakes" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.829z"></path>
                                </svg>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('nakes.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nakes {{ $doc->name }}?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Hapus Nakes" style="display: inline-flex; align-items: center; justify-content: center;">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- MODAL EDIT NAKES -->
                        <div id="editDoctor_{{ $doc->id }}" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(44, 62, 43, 0.4); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;">
                            <div class="card" style="width: 100%; max-width: 500px; text-align: left;">
                                <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                                    <h3 class="card-title">Edit Data Tenaga Kesehatan</h3>
                                    <button type="button" onclick="toggleModal('editDoctor_{{ $doc->id }}', false)" style="background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer;">✕</button>
                                </div>
                                
                                <form action="{{ route('nakes.update', $doc->id) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group">
                                        <label for="name_{{ $doc->id }}">Nama Lengkap & Gelar <span style="color: var(--danger);">*</span></label>
                                        <input type="text" id="name_{{ $doc->id }}" name="name" value="{{ $doc->name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="specialty_{{ $doc->id }}">Spesialisasi Medis <span style="color: var(--danger);">*</span></label>
                                        <input type="text" id="specialty_{{ $doc->id }}" name="specialty" value="{{ $doc->specialty }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="dept_{{ $doc->id }}">Departemen Tugas / Poli <span style="color: var(--danger);">*</span></label>
                                        <input type="text" id="dept_{{ $doc->id }}" name="department" value="{{ $doc->department }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="status_{{ $doc->id }}">Status Praktik <span style="color: var(--danger);">*</span></label>
                                        <select id="status_{{ $doc->id }}" name="status" required>
                                            <option value="Available" {{ $doc->status === 'Available' ? 'selected' : '' }}>Aktif / Praktik</option>
                                            <option value="Not Available" {{ $doc->status === 'Not Available' ? 'selected' : '' }}>Tidak Praktik</option>
                                        </select>
                                    </div>

                                    <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
                                        <button type="button" class="btn-outline" onclick="toggleModal('editDoctor_{{ $doc->id }}', false)">Batal</button>
                                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Tidak ada data tenaga kesehatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL ADD DOCTOR -->
<div id="doctorModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(44, 62, 43, 0.4); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 500px; animation: slideDown 0.3s ease;">
        <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
            <h3 class="card-title">Daftarkan Tenaga Kesehatan Baru</h3>
            <button onclick="toggleModal('doctorModal', false)" style="background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer;">✕</button>
        </div>
        
        <form action="{{ route('nakes.store') }}" method="POST" style="margin-top: 15px;">
            @csrf
            
            <div class="form-group">
                <label for="add_name">Nama Lengkap & Gelar <span style="color: var(--danger);">*</span></label>
                <input type="text" id="add_name" name="name" required placeholder="Contoh: Dr. Sheryl Glass">
            </div>

            <div class="form-group">
                <label for="add_spec">Spesialisasi Medis <span style="color: var(--danger);">*</span></label>
                <input type="text" id="add_spec" name="specialty" required placeholder="Contoh: Dermatology">
            </div>

            <div class="form-group">
                <label for="add_dept">Departemen Tugas / Poli <span style="color: var(--danger);">*</span></label>
                <input type="text" id="add_dept" name="department" required placeholder="Contoh: Dermatologist">
            </div>

            <div class="form-group">
                <label for="add_status">Status Praktik <span style="color: var(--danger);">*</span></label>
                <select id="add_status" name="status" required>
                    <option value="Available">Aktif / Praktik</option>
                    <option value="Not Available">Tidak Praktik</option>
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
                <button type="button" class="btn-outline" onclick="toggleModal('doctorModal', false)">Batal</button>
                <button type="submit" class="btn-primary">Daftarkan Nakes</button>
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

@extends('layouts.app')

@section('title', 'Pendaftaran & Data Pasien | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <span class="breadcrumb-item active">Pendaftaran & Data Pasien</span>
    </div>
    
    <button class="btn-primary" onclick="toggleModal('registerModal', true)" style="display: flex; align-items: center; gap: 6px;">
        <!-- User Add Icon -->
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
        </svg>
        <span>Daftarkan Pasien Baru</span>
    </button>
</div>

<!-- PATIENTS TABLE CARD -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div class="card-title-bar" style="padding: 24px 24px 10px 24px; border-bottom: 1px solid var(--border-color); background-color: var(--white); margin-bottom: 0;">
        <h3 class="card-title">Daftar Pasien Poliklinik</h3>
        
        <!-- Search and Filter Form -->
        <form action="{{ route('patients.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <!-- Category Filtering Dropdown -->
            <div class="form-group" style="margin-bottom: 0; width: 200px; gap: 0;">
                <select name="type" onchange="this.form.submit()" style="height: 38px; font-size: 13px; padding: 6px 10px;">
                    <option value="">-- Semua Kategori Pasien --</option>
                    <option value="Murid" {{ $type === 'Murid' ? 'selected' : '' }}>Murid (Kode A)</option>
                    <option value="Pegawai" {{ $type === 'Pegawai' ? 'selected' : '' }}>Pegawai (Kode B)</option>
                    <option value="Keluarga Pegawai" {{ $type === 'Keluarga Pegawai' ? 'selected' : '' }}>Keluarga Pegawai (Kode C)</option>
                    <option value="Forsipa" {{ $type === 'Forsipa' ? 'selected' : '' }}>Forsipa (Kode D)</option>
                    <option value="Umum" {{ $type === 'Umum' ? 'selected' : '' }}>Umum (Kode E)</option>
                </select>
            </div>

            <!-- Search input -->
            <div class="search-bar" style="width: 260px; position: relative;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NIK, atau Kode..." style="padding-left: 36px; height: 38px; font-size: 13px;">
            </div>
            
            <button type="submit" class="btn-primary" style="padding: 8px 16px; height: 38px; font-size: 13px; box-shadow: none;">Cari</button>
            
            @if($search || $type)
                <a href="{{ route('patients.index') }}" class="btn-outline" style="padding: 8px 16px; height: 38px; font-size: 13px; display: flex; align-items: center;">Reset</a>
            @endif
        </form>
    </div>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Pasien</th>
                    <th>Nama Pasien</th>
                    <th>NIK</th>
                    <th>Kategori Pasien</th>
                    <th>Umur</th>
                    <th>Gender</th>
                    <th>No. Telepon</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $index => $patient)
                <tr>
                    <td>{{ sprintf('%02d', ($patients->currentPage() - 1) * $patients->perPage() + $index + 1) }}</td>
                    <td style="font-family: monospace; font-weight: 700; color: var(--primary-color);">{{ $patient->patient_code }}</td>
                    <td>
                        <div class="patient-table-name">
                            <div class="patient-table-avatar" style="background-color: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;">
                                {{ strtoupper(substr($patient->name, 0, 2)) }}
                            </div>
                            <span>{{ $patient->name }}</span>
                        </div>
                    </td>
                    <td style="font-family: monospace;">{{ $patient->nik }}</td>
                    <td>
                        <span class="badge-category">
                            {{ $patient->patient_type }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Tahun</td>
                    <td>
                        <span class="status-pill" style="background-color: {{ $patient->gender === 'Male' ? '#e0f2fe' : '#fce7f3' }}; color: {{ $patient->gender === 'Male' ? '#0369a1' : '#db2777' }};">
                            {{ $patient->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td>{{ $patient->phone }}</td>
                    <td>
                        <div class="action-buttons">
                            <!-- Detail View -->
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn-icon view" title="Lihat RME" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            
                            <!-- Edit Patient -->
                            <button onclick="toggleModal('editModal_{{ $patient->id }}', true)" class="btn-icon edit" title="Edit Profil Pasien" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.829z"></path>
                                </svg>
                            </button>

                            <!-- Delete Patient -->
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini beserta seluruh riwayat RME terkait?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Hapus Pasien" style="display: inline-flex; align-items: center; justify-content: center;">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- MODAL EDIT PASIEN -->
                        <div id="editModal_{{ $patient->id }}" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(44, 62, 43, 0.4); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;">
                            <div class="card" style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; text-align: left;">
                                <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                                    <h3 class="card-title">Edit Profil Pasien</h3>
                                    <button type="button" onclick="toggleModal('editModal_{{ $patient->id }}', false)" style="background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer;">✕</button>
                                </div>
                                
                                <form action="{{ route('patients.update', $patient->id) }}" method="POST" style="margin-top: 15px;">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="name_{{ $patient->id }}">Nama Lengkap Pasien <span style="color: var(--danger);">*</span></label>
                                            <input type="text" id="name_{{ $patient->id }}" name="name" value="{{ $patient->name }}" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="nik_{{ $patient->id }}">NIK (16 Digit KTP) <span style="color: var(--danger);">*</span></label>
                                            <input type="text" id="nik_{{ $patient->id }}" name="nik" value="{{ $patient->nik }}" required minlength="16" maxlength="16">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="type_{{ $patient->id }}">Kategori Pasien <span style="color: var(--danger);">*</span></label>
                                            <select id="type_{{ $patient->id }}" name="patient_type" required>
                                                <option value="Murid" {{ $patient->patient_type === 'Murid' ? 'selected' : '' }}>Murid (Kode A)</option>
                                                <option value="Pegawai" {{ $patient->patient_type === 'Pegawai' ? 'selected' : '' }}>Pegawai (Kode B)</option>
                                                <option value="Keluarga Pegawai" {{ $patient->patient_type === 'Keluarga Pegawai' ? 'selected' : '' }}>Keluarga Pegawai (Kode C)</option>
                                                <option value="Forsipa" {{ $patient->patient_type === 'Forsipa' ? 'selected' : '' }}>Forsipa (Kode D)</option>
                                                <option value="Umum" {{ $patient->patient_type === 'Umum' ? 'selected' : '' }}>Umum (Kode E)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="dob_{{ $patient->id }}">Tanggal Lahir <span style="color: var(--danger);">*</span></label>
                                            <input type="date" id="dob_{{ $patient->id }}" name="date_of_birth" value="{{ $patient->date_of_birth }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="gender_{{ $patient->id }}">Jenis Kelamin <span style="color: var(--danger);">*</span></label>
                                            <select id="gender_{{ $patient->id }}" name="gender" required>
                                                <option value="Male" {{ $patient->gender === 'Male' ? 'selected' : '' }}>Laki-laki (Male)</option>
                                                <option value="Female" {{ $patient->gender === 'Female' ? 'selected' : '' }}>Perempuan (Female)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone_{{ $patient->id }}">Nomor Telepon/HP <span style="color: var(--danger);">*</span></label>
                                            <input type="text" id="phone_{{ $patient->id }}" name="phone" value="{{ $patient->phone }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address_{{ $patient->id }}">Alamat Lengkap KTP <span style="color: var(--danger);">*</span></label>
                                        <textarea id="address_{{ $patient->id }}" name="address" rows="3" required>{{ $patient->address }}</textarea>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="allergies_{{ $patient->id }}">Riwayat Alergi (Obat/Makanan)</label>
                                            <input type="text" id="allergies_{{ $patient->id }}" name="allergies" value="{{ $patient->allergies }}">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="history_{{ $patient->id }}">Riwayat Penyakit Dahulu</label>
                                            <input type="text" id="history_{{ $patient->id }}" name="medical_history" value="{{ $patient->medical_history }}">
                                        </div>
                                    </div>

                                    <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
                                        <button type="button" class="btn-outline" onclick="toggleModal('editModal_{{ $patient->id }}', false)">Batal</button>
                                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--text-muted); padding: 30px;">Tidak ada data pasien yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div style="padding: 16px 24px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 13px; color: var(--text-muted);">
            Menampilkan {{ $patients->firstItem() ?? 0 }} - {{ $patients->lastItem() ?? 0 }} dari {{ $patients->total() }} pasien
        </span>
        <div style="display: flex; gap: 6px;">
            @if ($patients->onFirstPage())
                <button class="btn-outline" style="opacity: 0.5; cursor: not-allowed; padding: 6px 12px; font-size: 12px;" disabled>Sebelumnya</button>
            @else
                <a href="{{ $patients->appends(request()->input())->previousPageUrl() }}" class="btn-outline" style="padding: 6px 12px; font-size: 12px;">Sebelumnya</a>
            @endif

            @if ($patients->hasMorePages())
                <a href="{{ $patients->appends(request()->input())->nextPageUrl() }}" class="btn-outline" style="padding: 6px 12px; font-size: 12px;">Berikutnya</a>
            @else
                <button class="btn-outline" style="opacity: 0.5; cursor: not-allowed; padding: 6px 12px; font-size: 12px;" disabled>Berikutnya</button>
            @endif
        </div>
    </div>
</div>

<!-- MODAL REGISTRASI PASIEN BARU -->
<div id="registerModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(44, 62, 43, 0.4); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; animation: slideDown 0.3s ease;">
        <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
            <h3 class="card-title">Form Pendaftaran Pasien Baru</h3>
            <button onclick="toggleModal('registerModal', false)" style="background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer;">✕</button>
        </div>
        
        <form action="{{ route('patients.store') }}" method="POST" style="margin-top: 15px;">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Lengkap Pasien <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="name" name="name" required placeholder="Contoh: Deena Cooley">
                </div>
                
                <div class="form-group">
                    <label for="nik">NIK (16 Digit KTP) <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nik" name="nik" required minlength="16" maxlength="16" placeholder="Contoh: 3171012345670001">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="patient_type">Kategori Pasien <span style="color: var(--danger);">*</span></label>
                    <select id="patient_type" name="patient_type" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Murid">Murid (Kode A)</option>
                        <option value="Pegawai">Pegawai (Kode B)</option>
                        <option value="Keluarga Pegawai">Keluarga Pegawai (Kode C)</option>
                        <option value="Forsipa">Forsipa (Kode D)</option>
                        <option value="Umum">Umum (Kode E)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir <span style="color: var(--danger);">*</span></label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="gender">Jenis Kelamin <span style="color: var(--danger);">*</span></label>
                    <select id="gender" name="gender" required>
                        <option value="">Pilih Gender</option>
                        <option value="Male">Laki-laki (Male)</option>
                        <option value="Female">Perempuan (Female)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon/HP <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="phone" name="phone" required placeholder="Contoh: 08123456789">
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat Lengkap KTP <span style="color: var(--danger);">*</span></label>
                <textarea id="address" name="address" rows="3" required placeholder="Masukkan alamat lengkap rumah pasien..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="allergies">Riwayat Alergi (Obat/Makanan)</label>
                    <input type="text" id="allergies" name="allergies" placeholder="Contoh: Penisilin, Telur (Kosongkan jika tidak ada)">
                </div>
                
                <div class="form-group">
                    <label for="medical_history">Riwayat Penyakit Dahulu</label>
                    <input type="text" id="medical_history" name="medical_history" placeholder="Contoh: Diabetes, Asma, Hipertensi">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
                <button type="button" class="btn-outline" onclick="toggleModal('registerModal', false)">Batal</button>
                <button type="submit" class="btn-primary">Daftarkan Pasien</button>
            </div>
        </form>
    </div>
</div>

<style>
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

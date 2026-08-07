@extends('layouts.app')

@section('title', 'Input Rekam Medis Baru | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <span class="breadcrumb-item active">Input Rekam Medis Baru</span>
    </div>
    
    <a href="{{ $selectedPatientId ? route('patients.show', $selectedPatientId) : route('patients.index') }}" class="btn-outline" style="display: flex; align-items: center; gap: 6px;">
        <!-- Close SVG -->
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
        <span>Batal</span>
    </a>
</div>

<!-- FORM CARD -->
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
        <h3 class="card-title">Pemeriksaan Medis & Input Rekap RME</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="flex-direction: column; align-items: flex-start;">
            <div style="font-weight: 700; margin-bottom: 6px;">Periksa kembali form Anda:</div>
            <ul style="padding-left: 20px; font-size: 13px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rme.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <!-- Patient Selector -->
            <div class="form-group">
                <label for="patient_id">Pilih Pasien <span style="color: var(--danger);">*</span></label>
                <select id="patient_id" name="patient_id" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach($patients as $pat)
                        <option value="{{ $pat->id }}" {{ $selectedPatientId == $pat->id ? 'selected' : '' }}>
                            {{ $pat->name }} (NIK: {{ $pat->nik }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor Selector -->
            <div class="form-group">
                <label for="doctor_id">Dokter Pemeriksa <span style="color: var(--danger);">*</span></label>
                <select id="doctor_id" name="doctor_id" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                            {{ $doc->name }} ({{ $doc->specialty }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="complaints">Keluhan Utama Pasien (Anamnesis) <span style="color: var(--danger);">*</span></label>
            <textarea id="complaints" name="complaints" rows="3" required placeholder="Contoh: Pasien mengeluhkan demam tinggi sejak 2 hari yang lalu disertai batuk kering...">{{ old('complaints') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="physical_check">Pemeriksaan Fisik & Tanda Vital</label>
                <input type="text" id="physical_check" name="physical_check" value="{{ old('physical_check') }}" placeholder="Contoh: TD: 120/80 mmHg, Nadi: 82x/m, Suhu: 38.5 C">
            </div>

            <!-- Disease Classification for Analytics -->
            <div class="form-group">
                <label for="disease">Klasifikasi Penyakit (Untuk Analitik)</label>
                <select id="disease" name="disease">
                    <option value="Checkup">General Checkup</option>
                    <option value="Fever" {{ old('disease') == 'Fever' ? 'selected' : '' }}>Fever (Demam)</option>
                    <option value="Cold" {{ old('disease') == 'Cold' ? 'selected' : '' }}>Cold (Batuk/Pilek)</option>
                    <option value="Diabetes" {{ old('disease') == 'Diabetes' ? 'selected' : '' }}>Diabetes</option>
                    <option value="Asthma" {{ old('disease') == 'Asthma' ? 'selected' : '' }}>Asthma</option>
                    <option value="Prostate" {{ old('disease') == 'Prostate' ? 'selected' : '' }}>Prostate</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="diagnosis">Diagnosa ICD-10 <span style="color: var(--danger);">*</span></label>
                <input type="text" id="diagnosis" name="diagnosis" value="{{ old('diagnosis') }}" required placeholder="Contoh: J10.1 Influenza dengan Manifestasi Pernapasan" list="icd10-list">
                <datalist id="icd10-list">
                    <option value="K35.8 Acute appendicitis">
                    <option value="J10.1 Influenza with other respiratory manifestations">
                    <option value="J00 Acute nasopharyngitis (common cold)">
                    <option value="N40 Hyperplasia of prostate">
                    <option value="J45 Asthma">
                    <option value="E11 Type 2 diabetes mellitus">
                    <option value="I10 Essential (primary) hypertension">
                </datalist>
            </div>

            <div class="form-group">
                <label for="action_taken">Tindakan Medis</label>
                <input type="text" id="action_taken" name="action_taken" value="{{ old('action_taken') }}" placeholder="Contoh: Nebulizer, Pemberian Infus, Rujukan Bedah">
            </div>
        </div>

        <!-- PRESCRIPTION LOGIC -->
        <div style="background-color: var(--bg-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px; margin: 20px 0;">
            <h4 style="font-size: 14px; font-weight: 700; color: var(--primary-color); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <!-- Medicine icon -->
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zM6 6a2 2 0 00-2 2v9a2 2 0 002 2h8a2 2 0 002-2V8a2 2 0 00-2-2H6zm2 5a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>Resep & Pemberian Obat (Apotek)</span>
            </h4>
            
            <div class="form-row" style="grid-template-columns: 2fr 1fr;">
                <div class="form-group">
                    <label for="medicine_id">Pilih Obat dari Inventaris</label>
                    <select id="medicine_id" name="medicine_id">
                        <option value="">-- Tanpa Pemberian Obat --</option>
                        @foreach($medicines as $med)
                            <option value="{{ $med->id }}" {{ old('medicine_id') == $med->id ? 'selected' : '' }}>
                                {{ $med->name }} (Sisa Stok: {{ $med->stock }} {{ $med->formulation }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="medicine_qty">Jumlah/Qty</label>
                    <input type="number" id="medicine_qty" name="medicine_qty" value="{{ old('medicine_qty') }}" min="1" placeholder="Contoh: 10">
                </div>
            </div>

            <div class="form-group">
                <label for="prescription_notes">Instruksi Tambahan Aturan Pakai</label>
                <textarea id="prescription_notes" name="prescription_notes" rows="2" placeholder="Contoh: Paracetamol 3x1 setelah makan jika demam. Amoxicillin harus dihabiskan.">{{ old('prescription_notes') }}</textarea>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
            <a href="{{ $selectedPatientId ? route('patients.show', $selectedPatientId) : route('patients.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary" style="display: flex; align-items: center; gap: 6px;">
                <!-- Save icon -->
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Simpan Pemeriksaan & Kurangi Stok</span>
            </button>
        </div>
    </form>
</div>
@endsection

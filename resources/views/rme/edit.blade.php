@extends('layouts.app')

@section('title', 'Edit Rekam Medis - ' . $record->patient->name . ' | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <a href="{{ route('patients.show', $record->patient_id) }}">Pasien</a>
        <span>/</span>
        <span class="breadcrumb-item active">Edit RME</span>
    </div>
    
    <a href="{{ route('patients.show', $record->patient_id) }}" class="btn-outline" style="display: flex; align-items: center; gap: 6px;">
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
        <h3 class="card-title">Edit Pemeriksaan Medis (RME Draf)</h3>
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

    <form action="{{ route('rme.update', $record->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <!-- Patient Name (Read-only) -->
            <div class="form-group">
                <label>Nama Pasien</label>
                <input type="text" value="{{ $record->patient->name }} (NIK: {{ $record->patient->nik }})" readonly style="background-color: var(--bg-color); cursor: not-allowed;">
                <input type="hidden" name="patient_id" value="{{ $record->patient_id }}">
            </div>

            <!-- Doctor Selector -->
            <div class="form-group">
                <label for="doctor_id">Dokter Pemeriksa <span style="color: var(--danger);">*</span></label>
                <select id="doctor_id" name="doctor_id" required>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ $record->doctor_id == $doc->id ? 'selected' : '' }}>
                            {{ $doc->name }} ({{ $doc->specialty }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="complaints">Keluhan Utama Pasien (Anamnesis) <span style="color: var(--danger);">*</span></label>
            <textarea id="complaints" name="complaints" rows="3" required>{{ old('complaints', $record->complaints) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="physical_check">Pemeriksaan Fisik & Tanda Vital</label>
                <input type="text" id="physical_check" name="physical_check" value="{{ old('physical_check', $record->physical_check) }}">
            </div>

            <!-- Disease Classification -->
            <div class="form-group">
                <label for="disease">Klasifikasi Penyakit (Untuk Analitik)</label>
                <select id="disease" name="disease">
                    <option value="Checkup" {{ $record->disease == 'Checkup' ? 'selected' : '' }}>General Checkup</option>
                    <option value="Fever" {{ $record->disease == 'Fever' ? 'selected' : '' }}>Fever (Demam)</option>
                    <option value="Cold" {{ $record->disease == 'Cold' ? 'selected' : '' }}>Cold (Batuk/Pilek)</option>
                    <option value="Diabetes" {{ $record->disease == 'Diabetes' ? 'selected' : '' }}>Diabetes</option>
                    <option value="Asthma" {{ $record->disease == 'Asthma' ? 'selected' : '' }}>Asthma</option>
                    <option value="Prostate" {{ $record->disease == 'Prostate' ? 'selected' : '' }}>Prostate</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="diagnosis">Diagnosa ICD-10 <span style="color: var(--danger);">*</span></label>
                <input type="text" id="diagnosis" name="diagnosis" value="{{ old('diagnosis', $record->diagnosis) }}" required list="icd10-list">
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
                <input type="text" id="action_taken" name="action_taken" value="{{ old('action_taken', $record->action_taken) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="prescription_notes">Resep Obat & Instruksi Aturan Pakai</label>
            <textarea id="prescription_notes" name="prescription_notes" rows="3">{{ old('prescription_notes', $record->prescription_notes) }}</textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 20px;">
            <a href="{{ route('patients.show', $record->patient_id) }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary" style="display: flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection

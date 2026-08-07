@extends('layouts.app')

@section('title', $patient->name . ' - Detail RME | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <a href="{{ route('patients.index') }}">Pasien</a>
        <span>/</span>
        <span class="breadcrumb-item active">{{ $patient->name }}</span>
    </div>
    
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('patients.index') }}" class="btn-outline" style="display: flex; align-items: center; gap: 6px;">
            <!-- Arrow Left SVG -->
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
            </svg>
            <span>Kembali</span>
        </a>
        <a href="{{ route('rme.create', ['patient_id' => $patient->id]) }}" class="btn-primary" style="display: flex; align-items: center; gap: 6px;">
            <!-- Plus SVG -->
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            <span>Pemeriksaan Medis (RME) Baru</span>
        </a>
    </div>
</div>

<div class="profile-container">
    <!-- LEFT SIDEBAR: PATIENT PROFILE CARD -->
    <div class="card profile-sidebar-card">
        <div class="profile-large-avatar" style="background-color: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 36px; margin: 0 auto 16px auto;">
            {{ strtoupper(substr($patient->name, 0, 2)) }}
        </div>
        <h2 class="profile-main-name">{{ $patient->name }}</h2>
        <span class="profile-role" style="color: var(--primary-color); font-weight: 600;">Pasien Poliklinik</span>
        <span class="profile-patient-nik">NIK: {{ $patient->nik }}</span>
        
        <div class="profile-badge-list">
            @if($patient->allergies)
                <span class="profile-badge-item allergy">Alergi: {{ $patient->allergies }}</span>
            @endif
            @if($patient->medical_history)
                <span class="profile-badge-item history">Riwayat: {{ $patient->medical_history }}</span>
            @endif
        </div>
        
        <div style="width: 100%; border-top: 1px solid var(--border-color); margin-top: 24px; padding-top: 20px; text-align: left;">
            <div class="profile-details-grid" style="grid-template-columns: 1fr;">
                <div class="detail-item" style="margin-bottom: 12px;">
                    <h5>Tanggal Lahir</h5>
                    <p>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d F Y') }} ({{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Tahun)</p>
                </div>
                <div class="detail-item" style="margin-bottom: 12px;">
                    <h5>Jenis Kelamin</h5>
                    <p>{{ $patient->gender === 'Male' ? 'Laki-laki (Male)' : 'Perempuan (Female)' }}</p>
                </div>
                <div class="detail-item" style="margin-bottom: 12px;">
                    <h5>Nomor Telepon</h5>
                    <p>{{ $patient->phone }}</p>
                </div>
                <div class="detail-item">
                    <h5>Alamat Rumah</h5>
                    <p style="font-size: 13.5px; line-height: 1.4; color: var(--text-color);">{{ $patient->address }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT CONTENT: MEDICAL RECORDS (RME) TIMELINE -->
    <div class="card" style="flex-grow: 1;">
        <div class="card-title-bar" style="border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px;">
            <h3 class="card-title">Riwayat Rekam Medis Elektronik (RME)</h3>
        </div>
        
        @if($patient->medicalRecords->count() > 0)
            <div class="rme-timeline">
                @foreach($patient->medicalRecords->sortByDesc('id') as $record)
                <div class="rme-timeline-item">
                    <div class="rme-timeline-dot"></div>
                    <div class="rme-timeline-card">
                        <div class="rme-header">
                            <div class="rme-header-left">
                                <h4 style="font-weight: 700; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                                    <span>Pemeriksaan oleh {{ $record->doctor->name }}</span>
                                    
                                    <!-- Lock status badge -->
                                    @if($record->status === 'Closed')
                                        <span class="status-pill available" style="background-color: var(--primary-light); color: var(--primary-color); font-size: 10px; padding: 2px 8px;">🔒 Terkunci (Selesai)</span>
                                    @else
                                        <span class="status-pill" style="background-color: #fef3c7; color: #d97706; font-size: 10px; padding: 2px 8px;">🔓 Terbuka (Draf)</span>
                                    @endif
                                </h4>
                                <p>{{ $record->doctor->specialty }} - {{ $record->doctor->department }}</p>
                            </div>
                            <div class="rme-header-right" style="display: flex; align-items: center; gap: 6px;">
                                <!-- Calendar SVG -->
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }} ({{ $record->appointment_time }})</span>
                            </div>
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 12px; border-top: 1px dashed var(--border-color); padding-top: 12px;">
                            <div class="rme-body-section">
                                <h5>Keluhan Pasien (Anamnesis)</h5>
                                <p>{{ $record->complaints }}</p>
                            </div>
                            
                            @if($record->physical_check)
                            <div class="rme-body-section">
                                <h5>Pemeriksaan Fisik & Tanda Vital</h5>
                                <p style="font-family: monospace; background-color: var(--white); padding: 6px 12px; border: 1px solid var(--border-color); border-radius: 4px; display: inline-block;">
                                    {{ $record->physical_check }}
                                </p>
                            </div>
                            @endif
                            
                            <div class="rme-body-section">
                                <h5>Diagnosa Medis (ICD-10)</h5>
                                <p><span class="badge-disease" style="background-color: var(--primary-light); color: var(--primary-color); font-size: 13px; padding: 4px 8px;">{{ $record->diagnosis }}</span></p>
                            </div>
                            
                            @if($record->action_taken)
                            <div class="rme-body-section">
                                <h5>Tindakan Medis</h5>
                                <p>{{ $record->action_taken }}</p>
                            </div>
                            @endif
                            
                            @if($record->prescription_notes)
                            <div class="rme-body-section" style="background-color: #f7fee7; border: 1px solid #d9f99d; border-radius: 6px; padding: 12px; margin-bottom: 8px;">
                                <h5 style="color: #3f6212; display: flex; align-items: center; gap: 6px;">
                                    <!-- Pill SVG -->
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zM6 6a2 2 0 00-2 2v9a2 2 0 002 2h8a2 2 0 002-2V8a2 2 0 00-2-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Resep Obat (Prescription)</span>
                                </h5>
                                <p style="font-family: monospace; white-space: pre-line; margin-top: 6px; font-size: 13px; color: #1a2e05;">{{ $record->prescription_notes }}</p>
                            </div>
                            @endif
                            
                            <!-- PRINTING & EDIT/LOCK ACTION BAR -->
                            <div style="display: flex; gap: 8px; border-top: 1px solid var(--border-color); padding-top: 12px; margin-top: 8px; flex-wrap: wrap;">
                                <button class="btn-outline" onclick="printElement('print-rme-{{ $record->id }}')" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span>🖨️ Cetak RME</span>
                                </button>
                                
                                @if($record->prescription_notes)
                                <button class="btn-outline" onclick="printElement('print-rx-{{ $record->id }}')" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span>🖨️ Cetak Resep</span>
                                </button>
                                @endif
                                
                                <button class="btn-outline" onclick="printElement('print-cert-{{ $record->id }}')" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span>🖨️ Cetak Surat Sakit</span>
                                </button>

                                <!-- Draft Action: Edit / Lock RME -->
                                @if($record->status === 'Draft')
                                    <a href="{{ route('rme.edit', $record->id) }}" class="btn-outline" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px; border-color: var(--warning); color: #b45309; background-color: #fffbeb;">
                                        <span>✏️ Edit RME</span>
                                    </a>

                                    <form action="{{ route('rme.lock', $record->id) }}" method="POST" onsubmit="return confirm('Kunci Rekam Medis ini secara permanen? Setelah dikunci, isi data medis dan resep obat tidak dapat diubah kembali.');" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-primary" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px; background-color: var(--danger); box-shadow: none;">
                                            <span>🔒 Kunci & Selesai</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HIDDEN PRINT TEMPLATES -->
                <!-- 1. RME Sheet -->
                <div id="print-rme-{{ $record->id }}" class="print-only">
                    <div class="print-header">
                        <div class="print-logo-title">POLIKLINIK AL-AZHAR</div>
                        <div class="print-subtitle">Kawasan Kampus Al-Azhar, Jl. Sisingamangaraja, Jakarta | Telp: 0987654321</div>
                    </div>
                    <h3 style="text-align: center; margin-bottom: 20px; font-weight: 700; text-transform: uppercase;">Lembar Rekam Medis Elektronik (RME)</h3>
                    
                    <div class="print-meta-grid">
                        <div class="print-meta-item"><strong>Nama Pasien</strong>: {{ $patient->name }}</div>
                        <div class="print-meta-item"><strong>Dokter Pemeriksa</strong>: {{ $record->doctor->name }}</div>
                        <div class="print-meta-item"><strong>NIK Pasien</strong>: {{ $patient->nik }}</div>
                        <div class="print-meta-item"><strong>Spesialisasi Poli</strong>: {{ $record->doctor->specialty }}</div>
                        <div class="print-meta-item"><strong>Tanggal Lahir</strong>: {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d F Y') }}</div>
                        <div class="print-meta-item"><strong>Tanggal Periksa</strong>: {{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }}</div>
                        <div class="print-meta-item"><strong>Jenis Kelamin</strong>: {{ $patient->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}</div>
                        <div class="print-meta-item"><strong>Waktu/Jam</strong>: {{ $record->appointment_time }}</div>
                    </div>

                    <div class="print-section-title">Anamnesis / Keluhan Utama</div>
                    <div class="print-body-content">{{ $record->complaints }}</div>

                    @if($record->physical_check)
                    <div class="print-section-title">Pemeriksaan Fisik & Tanda Vital</div>
                    <div class="print-body-content">{{ $record->physical_check }}</div>
                    @endif

                    <div class="print-section-title">Diagnosa (ICD-10)</div>
                    <div class="print-body-content"><strong>{{ $record->diagnosis }}</strong></div>

                    @if($record->action_taken)
                    <div class="print-section-title">Tindakan Medis</div>
                    <div class="print-body-content">{{ $record->action_taken }}</div>
                    @endif

                    @if($record->prescription_notes)
                    <div class="print-section-title">Resep Obat</div>
                    <div class="print-body-content" style="font-family: monospace; white-space: pre-line; background: #fafafa; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ $record->prescription_notes }}</div>
                    @endif

                    <div class="print-signature-section">
                        <div class="print-signature-box">
                            <p>Pemeriksa,</p>
                            <div class="print-signature-line">{{ $record->doctor->name }}</div>
                            <p>SIP: {{ mt_rand(100000, 999999) }}/SIP/{{ now()->year }}</p>
                        </div>
                    </div>
                </div>

                <!-- 2. Prescription COPY -->
                <div id="print-rx-{{ $record->id }}" class="print-only">
                    <div class="print-header">
                        <div class="print-logo-title">POLIKLINIK AL-AZHAR</div>
                        <div class="print-subtitle">Kawasan Kampus Al-Azhar, Jl. Sisingamangaraja, Jakarta | Telp: 0987654321</div>
                    </div>
                    <h3 style="text-align: center; margin-bottom: 20px; font-weight: 700; text-transform: uppercase;">Salinan Resep Obat (Recipe copy)</h3>
                    
                    <div class="print-meta-grid" style="grid-template-columns: 1fr 1fr;">
                        <div class="print-meta-item"><strong>Nama Pasien</strong>: {{ $patient->name }}</div>
                        <div class="print-meta-item"><strong>Tanggal Resep</strong>: {{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }}</div>
                        <div class="print-meta-item"><strong>Umur Pasien</strong>: {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Tahun</div>
                        <div class="print-meta-item"><strong>Dokter Penulis</strong>: {{ $record->doctor->name }}</div>
                    </div>

                    <div style="font-size: 24px; font-weight: 700; font-family: 'Times New Roman', serif; margin: 15px 0;">R/</div>
                    <div class="print-body-content" style="font-family: monospace; font-size: 15px; line-height: 1.8; white-space: pre-line; padding-left: 20px; margin-bottom: 30px;">
                        {{ $record->prescription_notes }}
                    </div>

                    <div class="print-signature-section">
                        <div class="print-signature-box">
                            <p>Dokter Pemeriksa,</p>
                            <div class="print-signature-line">{{ $record->doctor->name }}</div>
                        </div>
                    </div>
                </div>

                <!-- 3. Sick Leave Certificate -->
                <div id="print-cert-{{ $record->id }}" class="print-only">
                    <div class="print-header">
                        <div class="print-logo-title">POLIKLINIK AL-AZHAR</div>
                        <div class="print-subtitle">Kawasan Kampus Al-Azhar, Jl. Sisingamangaraja, Jakarta | Telp: 0987654321</div>
                    </div>
                    <h3 style="text-align: center; margin-bottom: 25px; font-weight: 700; text-transform: uppercase; text-decoration: underline;">Surat Keterangan Sakit</h3>
                    
                    <div class="print-body-content" style="font-size: 15px; line-height: 2.0; text-align: justify; margin-top: 30px; margin-bottom: 40px;">
                        Yang bertanda tangan di bawah ini, dokter pemeriksa pada Poliklinik Al-Azhar Jakarta, menerangkan dengan sebenarnya bahwa pasien:
                        <br><br>
                        <table style="width: 100%; border: none;">
                            <tr style="border: none;"><td style="width: 150px; padding: 4px; border: none;"><strong>Nama Pasien</strong></td><td style="padding: 4px; border: none;">: {{ $patient->name }}</td></tr>
                            <tr style="border: none;"><td style="padding: 4px; border: none;"><strong>NIK</strong></td><td style="padding: 4px; border: none;">: {{ $patient->nik }}</td></tr>
                            <tr style="border: none;"><td style="padding: 4px; border: none;"><strong>Umur</strong></td><td style="padding: 4px; border: none;">: {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Tahun</td></tr>
                            <tr style="border: none;"><td style="padding: 4px; border: none;"><strong>Alamat Pasien</strong></td><td style="padding: 4px; border: none;">: {{ $patient->address }}</td></tr>
                        </table>
                        <br>
                        Berdasarkan hasil pemeriksaan medis yang telah dilakukan pada hari ini, dinyatakan bahwa pasien tersebut dalam keadaan **SAKIT** sehingga membutuhkan istirahat selama 3 (tiga) hari, terhitung dari tanggal **{{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }}** sampai dengan **{{ \Carbon\Carbon::parse($record->appointment_date)->addDays(2)->format('d M Y') }}**.
                        <br><br>
                        Demikian surat keterangan sakit ini dibuat dengan sejujurnya agar dapat dipergunakan sebagaimana mestinya.
                    </div>

                    <div class="print-signature-section">
                        <div class="print-signature-box">
                            <p>Jakarta, {{ \Carbon\Carbon::parse($record->appointment_date)->format('d M Y') }}</p>
                            <p>Dokter Pemeriksa,</p>
                            <div class="print-signature-line">{{ $record->doctor->name }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 50px 20px; color: var(--text-muted);">
                <!-- Folder Icon -->
                <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 16px; opacity: 0.5;">
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                </svg>
                <h3>Belum ada riwayat rekam medis (RME).</h3>
                <p style="margin-top: 8px; font-size: 14px;">Silakan buat catatan pemeriksaan medis baru menggunakan tombol di atas.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function printElement(elementId) {
        // Find existing print container, remove if any
        let existingPrintContainer = document.querySelector('body > .print-only');
        if (existingPrintContainer) {
            existingPrintContainer.remove();
        }

        // Get target element html
        const targetElement = document.getElementById(elementId);
        if (!targetElement) return;

        // Create temporary print container inside body
        const printContainer = document.createElement('div');
        printContainer.className = 'print-only';
        printContainer.innerHTML = targetElement.innerHTML;
        document.body.appendChild(printContainer);

        // Call print
        window.print();
        
        // Remove print container after printing completes
        setTimeout(() => {
            printContainer.remove();
        }, 500);
    }
</script>
@endsection

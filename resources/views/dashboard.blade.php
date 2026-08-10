@extends('layouts.app')

@section('title', 'Dashboard Medis | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
        </svg>
        <span>/</span>
        <span class="breadcrumb-item active">Dashboard Medis Utama</span>
    </div>
    <div class="date-range-picker">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span>{{ now()->subDays(7)->format('d/m/Y') }} - {{ now()->format('d/m/Y') }}</span>
    </div>
</div>

<!-- ROW 1: WELCOME BANNER & WEEKLY VISITS -->
<div class="grid-2">
    <!-- Welcome Banner with visible background -->
    <div class="card welcome-card">
        <div class="welcome-info">
            <span class="welcome-subtitle">Selamat Pagi,</span>
            <h1 class="welcome-title">dr. Siti Rahmawati, Sp.PD</h1>
            <p class="welcome-desc">Selamat datang kembali di sistem pengelolaan Poliklinik Al-Azhar. Pantau status antrean kunjungan pasien, riwayat Rekam Medis Elektronik (RME), serta ketersediaan stok obat apotek secara berkala.</p>
            
            <div class="welcome-stats">
                <div class="stat-pill">
                    <div class="stat-pill-icon">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2h2v2H6V6zm4 0h2v2h-2V6zm2 4H6v2h6v-2zm-6 4h6v2H6v-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-pill-number">{{ $displayAppointments }}</div>
                        <div class="stat-pill-label">Janji Kunjungan</div>
                    </div>
                </div>
                <div class="stat-pill">
                    <div class="stat-pill-icon">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707.293l-4 4a1 1 0 000 1.414l4 4a1 1 0 001.414-1.414L5.414 8H11a5 5 0 015 5 1 1 0 102 0 7 7 0 00-7-7H5.414l2.293-2.293A1 1 0 007 2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-pill-number">{{ $displaySurgeries }}</div>
                        <div class="stat-pill-label">Tindakan Medis</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Trend Line Chart -->
    <div class="card patients-trend-card">
        <div class="card-title-bar">
            <h3 class="card-title">Tren Kunjungan Pasien</h3>
            <a href="{{ route('mock.rekap', 'non-pendidikan') }}" class="btn-outline" style="padding: 5px 14px; font-size: 11.5px; border-radius: 20px; color: #ffffff; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.5); text-shadow: 0 1px 2px rgba(0,0,0,0.4); backdrop-filter: blur(4px);">
                Lihat Rekap &rsaquo;
            </a>
        </div>
        <div class="chart-container">
            <canvas id="patientsTrendChart"></canvas>
        </div>
        <div class="trend-stat">
            Jumlah kunjungan meningkat <span class="trend-highlight">80%</span> dalam seminggu terakhir.
        </div>
    </div>
</div>

<!-- ROW 2: DOCTORS, CONSULTATIONS, REVIEWS -->
<div class="grid-dashboard-row2">
    <!-- 1. Doctors Card (1fr) -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title">Daftar Dokter & Nakes</h3>
            <a href="{{ route('nakes.index') }}" class="btn-outline" style="padding: 4px 10px; font-size: 11.5px; border-radius: 20px;">
                Lihat Semua &rsaquo;
            </a>
        </div>
        <div class="doctors-list">
            @foreach($doctorsList as $doc)
            <div class="doctor-item">
                <div class="doctor-info-box">
                    <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=150&auto=format&fit=crop" alt="{{ $doc->name }}" class="doctor-list-avatar">
                    <div>
                        <div class="doctor-list-name">{{ $doc->name }}</div>
                        <div class="doctor-list-spec">{{ $doc->specialty }}</div>
                    </div>
                </div>
                <span class="status-pill {{ $doc->status === 'Available' ? 'available' : 'not-available' }}">
                    {{ $doc->status === 'Available' ? 'Praktik' : 'Tidak Praktik' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 2. Consultation Donut Card -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title">Statistik Konsultasi</h3>
            <a href="{{ route('patients.index') }}" class="btn-outline" style="padding: 4px 10px; font-size: 11.5px; border-radius: 20px;">
                Detail Pasien &rsaquo;
            </a>
        </div>
        <div class="donut-chart-container">
            <canvas id="consultationChart"></canvas>
            <div class="donut-inner-text">
                <h3>80%</h3>
                <p>Pasien Kunjungan Ulang</p>
            </div>
        </div>
        <div class="consultation-stats">
            <div class="consult-gender-pill">
                <div class="gender-icon male">
                    <!-- Solid Male SVG Symbol (♂) -->
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 3h5v5"/>
                        <path d="m21 3-7 7"/>
                        <circle cx="10" cy="14" r="5"/>
                    </svg>
                </div>
                <div class="gender-info">
                    <h5>{{ $displayMale }}</h5>
                    <p>Pasien Pria</p>
                </div>
            </div>
            <div class="consult-gender-pill">
                <div class="gender-icon female">
                    <!-- Solid Female SVG Symbol (♀) -->
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="9" r="5"/>
                        <path d="M12 14v7"/>
                        <path d="M9 17h6"/>
                    </svg>
                </div>
                <div class="gender-info">
                    <h5>{{ $displayFemale }}</h5>
                    <p>Pasien Wanita</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Reviews Card -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title">Ulasan & Penilaian Pasien</h3>
            <a href="{{ route('patients.index') }}" class="btn-outline" style="padding: 4px 10px; font-size: 11.5px; border-radius: 20px;">
                Semua Ulasan &rsaquo;
            </a>
        </div>
        <div class="reviews-box">
            <div class="reviewer-box">
                <div class="reviewer-profile">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&auto=format&fit=crop" alt="Kristie Jimenez" class="reviewer-avatar">
                    <div>
                        <div class="doctor-list-name" style="font-size: 13.5px;">Kristie Jimenez</div>
                        <!-- Solid SVG Stars -->
                        <div class="rating-stars" style="display: flex; gap: 2px; color: #f59e0b;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                    </div>
                </div>
                <span class="recommend-badge">Rekomendasi</span>
            </div>
            <p class="review-text" style="font-size: 13.5px; padding: 12px;">
                "Pelayanan di poliklinik sangat cepat dan dokter ramah. Sistem rekam medis barunya membuat proses pemeriksaan lebih efisien."
            </p>
            <button class="recommend-btn" onclick="alert('Rekomendasi dokter berhasil dikirim!')">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 9.2a2 2 0 00-.8 1.133z"></path>
                </svg>
                <span>Rekomendasikan Dokter</span>
            </button>
        </div>
    </div>
</div>

<!-- ROW 3: PATIENTS TABLE (RME STATUS) -->
<div class="card table-card">
    <div class="card-title-bar">
        <h3 class="card-title">Pendaftaran Kunjungan Terbaru</h3>
        <a href="{{ route('patients.index') }}" class="btn-primary" style="padding: 6px 12px; font-size: 12px; box-shadow: none; display: flex; align-items: center; gap: 6px;">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
            </svg>
            <span>Lihat Semua Pasien</span>
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pasien</th>
                    <th>Usia</th>
                    <th>Dokter Pemeriksa</th>
                    <th>Poli / Departemen</th>
                    <th>Tanggal</th>
                    <th>Waktu Kunjungan</th>
                    <th>Diagnosa / Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPatients as $index => $rec)
                <tr>
                    <td>{{ sprintf('%02d', $index + 1) }}</td>
                    <td>
                        <div class="patient-table-name">
                            <div class="patient-table-avatar" style="background-color: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 11px;">
                                {{ strtoupper(substr($rec->patient->name, 0, 2)) }}
                            </div>
                            <span>{{ $rec->patient->name }}</span>
                        </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($rec->patient->date_of_birth)->age }} Thn</td>
                    <td>{{ $rec->doctor->name }}</td>
                    <td><span class="badge-disease" style="background-color: var(--primary-light); color: var(--primary-color);">{{ $rec->doctor->department }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($rec->appointment_date)->format('d M Y') }}</td>
                    <td>{{ $rec->appointment_time ?? '09:00 WIB' }}</td>
                    <td><span class="badge-disease">{{ $rec->disease ?? 'Pemeriksaan Rutin' }}</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('patients.show', $rec->patient_id) }}" class="btn-icon view" title="Detail RME Pasien" style="display: flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--text-muted);">Belum ada rekam medis terdaftar hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ROW 4: 3 GRID CARDS AT BOTTOM OF DASHBOARD -->
<div class="grid-3" style="margin-top: 24px;">
    <!-- 1. Revenue & Daily Consult Chart Card (Dynamic from Rekap & Controller) -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title" style="font-size: 16px;">Pendapatan & Konsultasi</h3>
            <a href="{{ route('mock.rekap', 'non-pendidikan') }}" class="btn-outline" style="padding: 4px 10px; font-size: 11.5px; border-radius: 20px;">
                Lihat Rekap &rsaquo;
            </a>
        </div>
        <div class="chart-container" style="height: 180px;">
            <canvas id="revenueChart"></canvas>
        </div>
        <div style="margin-top: 10px; font-size: 12.5px; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center;">
            <span>Total Pendapatan Pekan Ini:</span>
            <strong style="color: var(--primary-color); font-size: 14px;">{{ $formattedTotalRevenue }}</strong>
        </div>
    </div>

    <!-- 2. Pharmacy Stock & Medicine Inventory Card (Dynamic Solid SVG Icons) -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title" style="font-size: 16px;">Stok & Inventaris Obat</h3>
            <a href="{{ route('medicines.index') }}" class="btn-outline" style="padding: 4px 10px; font-size: 11.5px; border-radius: 20px;">
                Gudang Obat &rsaquo;
            </a>
        </div>
        
        <div class="stock-warning-box" style="display: flex; align-items: center; gap: 12px; background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; padding: 12px 14px;">
            <!-- Solid SVG Warning Triangle Icon -->
            <div style="color: var(--warning); display: flex; align-items: center; flex-shrink: 0;">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="stock-warning-info">
                <h5 style="font-size: 13px; font-weight: 700; color: #92400e; margin: 0;">Stok Minimum</h5>
                <p style="font-size: 12px; color: #b45309; margin: 2px 0 0 0;">{{ $lowStockCount > 0 ? $lowStockCount : 3 }} item obat membutuhkan pengadaan ulang minggu ini.</p>
            </div>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($pharmacyItems as $item)
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px; padding-bottom: 6px; border-bottom: 1px solid var(--border-color);">
                <div>
                    <strong style="display: block;">{{ $item->name }}</strong>
                    <span style="font-size: 11px; color: {{ $item->stock < 30 ? 'var(--danger)' : 'var(--text-muted)' }};">
                        {{ $item->stock < 30 ? 'Stok Menipis' : 'Stok Aman' }}
                    </span>
                </div>
                <span class="status-pill {{ $item->stock < 30 ? 'not-available' : 'available' }}">
                    {{ $item->stock }} {{ $item->unit ?? 'Unit' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 3. Polyclinics & Departments Card (Dynamic Solid SVG Icons) -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title" style="font-size: 16px;">Poli & Layanan Utama</h3>
            <a href="{{ route('poli.index') }}" class="btn-outline" style="padding: 4px 10px; font-size: 11.5px; border-radius: 20px;">
                Kelola Poli &rsaquo;
            </a>
        </div>
        <div class="dept-list">
            <!-- Poli Umum (Solid Stethoscope SVG) -->
            <div class="dept-item">
                <div class="dept-icon" style="background-color: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v6h6a1 1 0 110 2h-6v6a1 1 0 11-2 0v-6H3a1 1 0 110-2h6V3a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="dept-info">
                    <h4>Poli Umum</h4>
                    <p>12 Dokter • 45 Kunjungan/Hari</p>
                </div>
            </div>

            <!-- Poli Gigi & Mulut (Solid Dental SVG) -->
            <div class="dept-item">
                <div class="dept-icon" style="background-color: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2C7 2 5 4 5 7c0 4 2 9 5 11 3-2 5-7 5-11 0-3-2-5-5-5z"></path>
                    </svg>
                </div>
                <div class="dept-info">
                    <h4>Poli Gigi & Mulut</h4>
                    <p>8 Dokter • 28 Kunjungan/Hari</p>
                </div>
            </div>

            <!-- Poli Spesialis Anak (Solid Pediatric SVG) -->
            <div class="dept-item">
                <div class="dept-icon" style="background-color: var(--primary-light); color: var(--primary-color); display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                </div>
                <div class="dept-info">
                    <h4>Poli Spesialis Anak</h4>
                    <p>6 Dokter • 32 Kunjungan/Hari</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Line Chart: Kunjungan Pasien
        const ctxTrend = document.getElementById('patientsTrendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Kunjungan Pasien',
                    data: [28, 45, 35, 50, 42, 60, 55],
                    borderColor: '#4F58BA',
                    backgroundColor: 'rgba(79, 88, 186, 0.25)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#4F58BA',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    },
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.08)' },
                        ticks: { color: '#94a3b8' }
                    }
                }
            }
        });

        // 2. Donut Chart: Kunjungan Pasien Pria vs Wanita
        // Blue (Pria) on LEFT, Pink (Wanita) on RIGHT
        const ctxConsult = document.getElementById('consultationChart').getContext('2d');
        new Chart(ctxConsult, {
            type: 'doughnut',
            data: {
                labels: ['Pasien Wanita', 'Pasien Pria'],
                datasets: [{
                    data: [{{ $displayFemale }}, {{ $displayMale }}],
                    backgroundColor: ['#db2777', '#4F58BA'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                rotation: -90,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // 3. Bar Chart: Dynamic Revenue & Daily Consultations (from Controller)
        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Pendapatan (Juta Rp)',
                    data: @json($dailyRevenueData),
                    backgroundColor: '#4F58BA',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 10 } }
                    },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: { color: '#64748b', font: { size: 10 } }
                    }
                }
            }
        });
    });
</script>
@endsection

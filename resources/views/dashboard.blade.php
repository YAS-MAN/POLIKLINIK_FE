@extends('layouts.app')

@section('title', 'Medical Dashboard | Poliklinik Al-Azhar')

@section('content')
<!-- SUB-HEADER -->
<div class="sub-header">
    <div class="breadcrumb">
        <!-- Home SVG -->
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--text-muted); margin-right: 4px;">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
        <span>/</span>
        <span class="breadcrumb-item active">Medical Dashboard</span>
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
            <span class="welcome-subtitle">Good Morning,</span>
            <h1 class="welcome-title">Dr. Ema Wilson</h1>
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
                        <div class="stat-pill-label">Appointments</div>
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
                        <div class="stat-pill-label">Surgeries</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Trend Line Chart (Dark theme box) -->
    <div class="card patients-trend-card">
        <div class="card-title-bar">
            <h3 class="card-title">Patients Trend</h3>
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
            <h3 class="card-title">Doctors</h3>
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
                    {{ $doc->status === 'Available' ? 'Available' : 'Not Available' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 2. Consultation Donut Card (0.75fr - Narrower Middle Column) -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title">Consultation</h3>
        </div>
        <div class="donut-chart-container">
            <canvas id="consultationChart"></canvas>
            <div class="donut-inner-text">
                <h3>80%</h3>
                <p>Returning Patients</p>
            </div>
        </div>
        <div class="consultation-stats">
            <div class="consult-gender-pill">
                <div class="gender-icon male">
                    <!-- Corrected Male SVG Symbol (♂) -->
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 3h5v5"/>
                        <path d="m21 3-7 7"/>
                        <circle cx="10" cy="14" r="5"/>
                    </svg>
                </div>
                <div class="gender-info">
                    <h5>{{ $displayMale }}</h5>
                    <p>Male Patients</p>
                </div>
            </div>
            <div class="consult-gender-pill">
                <div class="gender-icon female">
                    <!-- Corrected Female SVG Symbol (♀) -->
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="9" r="5"/>
                        <path d="M12 14v7"/>
                        <path d="M9 17h6"/>
                    </svg>
                </div>
                <div class="gender-info">
                    <h5>{{ $displayFemale }}</h5>
                    <p>Female Patients</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Reviews Card (1.25fr - Wider Right Column) -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title">Patient Review</h3>
        </div>
        <div class="reviews-box">
            <div class="reviewer-box">
                <div class="reviewer-profile">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&auto=format&fit=crop" alt="Kristie Jimenez" class="reviewer-avatar">
                    <div>
                        <div class="doctor-list-name" style="font-size: 13.5px;">Kristie Jimenez</div>
                        <div class="rating-stars">⭐⭐⭐⭐★</div>
                    </div>
                </div>
                <span class="recommend-badge">Recommend</span>
            </div>
            <p class="review-text" style="font-size: 13.5px; padding: 12px;">
                "Pelayanan di poliklinik sangat cepat dan dokter ramah. Sistem rekam medis barunya membuat proses pemeriksaan lebih efisien."
            </p>
            <button class="recommend-btn" onclick="alert('Rekomendasi dokter berhasil dikirim!')">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 9.2a2 2 0 00-.8 1.133z"></path>
                </svg>
                <span>Recommend doctor</span>
            </button>
        </div>
    </div>
</div>

<!-- ROW 3: PATIENTS TABLE (RME STATUS) -->
<div class="card table-card">
    <div class="card-title-bar">
        <h3 class="card-title">Recent Registered Patients</h3>
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
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Consulting Doctor</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Disease</th>
                    <th>Actions</th>
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
                    <td>{{ \Carbon\Carbon::parse($rec->patient->date_of_birth)->age }}</td>
                    <td>{{ $rec->doctor->name }}</td>
                    <td><span class="badge-disease" style="background-color: var(--primary-light); color: var(--primary-color);">{{ $rec->doctor->department }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($rec->appointment_date)->format('d M Y') }}</td>
                    <td>{{ $rec->appointment_time ?? 'N/A' }}</td>
                    <td><span class="badge-disease">{{ $rec->disease ?? 'Checkup' }}</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('patients.show', $rec->patient_id) }}" class="btn-icon view" title="Detail RME" style="display: flex; align-items: center; justify-content: center;">
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

<!-- ROW 4: REVENUE, PHARMACY, DEPARTMENTS -->
<div class="grid-3">
    <!-- Revenue & Patients Comparison -->
    <div class="card" style="grid-column: span 1;">
        <div class="card-title-bar">
            <h3 class="card-title">Revenue & Patients</h3>
        </div>
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Pharmacy Inventory Stocks -->
    <div class="card" style="grid-column: span 1;">
        <div class="card-title-bar">
            <h3 class="card-title">Pharmacy Stock</h3>
        </div>
        <div class="chart-container">
            <canvas id="pharmacyChart"></canvas>
        </div>
    </div>

    <!-- Departments Summary -->
    <div class="card">
        <div class="card-title-bar">
            <h3 class="card-title">Departments</h3>
        </div>
        <div class="dept-list">
            @foreach($departments as $dept)
            <div class="dept-item">
                <div class="dept-icon" style="font-size: 16px;">
                    @if($dept['name'] === 'General Physician')
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 7H7v6h6V7z"></path><path fill-rule="evenodd" d="M5 2a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V5a3 3 0 00-3-3H5zm0 2h10a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    @elseif($dept['name'] === 'Orthopedic')
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.06 1.06L9.19 9.3H4.75a.75.75 0 010-1.5h1.5a.75.75 0 010-1.5H4.75A2.25 2.25 0 002.5 8.5v3a2.25 2.25 0 002.25 2.25h1.5a.75.75 0 010-1.5h-1.5a.75.75 0 010-1.5h4.44l-1.31 1.31a.75.75 0 11-1.06-1.06L9.3 9.19V14.75a.75.75 0 01-1.5 0v-1.5a.75.75 0 01-1.5 0v1.5A2.25 2.25 0 008.5 17h3a2.25 2.25 0 002.25-2.25v-1.5a.75.75 0 011.5 0v1.5a.75.75 0 011.5 0v-1.5a2.25 2.25 0 00-2.25-2.25h-3v-4.44l1.31 1.31a.75.75 0 001.06-1.06l-2.5-2.5a.75.75 0 00-1.06 0l-2.5 2.5z" clip-rule="evenodd"></path></svg>
                    @else
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    @endif
                </div>
                <div class="dept-info">
                    <h4>{{ $dept['name'] }}</h4>
                    <p>{{ $dept['count'] }} Dokter Aktif</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Theme Colors
    const primaryColor = '#207F23';
    
    // 1. Patients Trend Line Chart (White Line)
    const ctxTrend = document.getElementById('patientsTrendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            datasets: [{
                label: 'Patients Visited',
                data: {!! json_encode($weeklyPatients) !!},
                borderColor: '#ffffff',
                borderWidth: 3,
                backgroundColor: 'rgba(255,255,255,0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ffffff',
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
                    ticks: { color: 'rgba(255,255,255,0.7)' }
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    ticks: { color: 'rgba(255,255,255,0.7)' }
                }
            }
        }
    });

    // 2. Consultation Donut Chart - REVERSED: 20% Gray slice at top-right, 80% Green filling left & bottom.
    const ctxConsult = document.getElementById('consultationChart').getContext('2d');
    new Chart(ctxConsult, {
        type: 'doughnut',
        data: {
            labels: ['New', 'Returning'],
            datasets: [{
                data: [20, 80],
                backgroundColor: ['#e2ebe2', primaryColor],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 3. Revenue vs Patients Comparison Chart
    const ctxRev = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRev, {
        type: 'line',
        data: {
            labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            datasets: [
                {
                    label: 'Income (x$100)',
                    data: {!! json_encode($revenueIncome) !!},
                    borderColor: '#228781',
                    borderWidth: 2.5,
                    fill: false,
                    tension: 0.3
                },
                {
                    label: 'Patients',
                    data: {!! json_encode($revenuePatients) !!},
                    borderColor: primaryColor,
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f3f4f6' } }
            }
        }
    });

    // 4. Pharmacy Inventory Stocks Bar Chart
    const ctxPharm = document.getElementById('pharmacyChart').getContext('2d');
    new Chart(ctxPharm, {
        type: 'bar',
        data: {
            labels: {!! json_encode($pharmacyLabels) !!}.map(n => n.split(' ')[0]), // take short names
            datasets: [{
                label: 'Stock Quantity',
                data: {!! json_encode($pharmacyStock) !!},
                backgroundColor: primaryColor,
                borderRadius: 4,
                maxBarThickness: 24
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f3f4f6' }, beginAtZero: true }
            }
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('title', 'Stok Obat Per Kampus | Poliklinik Al-Azhar')

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
        <span class="breadcrumb-item active">Stok Kampus</span>
    </div>
</div>

@if(!$selectedCampus)
<!-- CAMPUS LIST TABLE CARD -->
<div class="card" style="padding: 20px; border-radius: 16px; margin-top: 10px;">
    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background-color: #ffffff; color: #1e293b; border-bottom: 2px solid #e2e8f0;">
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 40px;">#</th>
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 80px;">Aksi</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Kampus</th>
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 120px;">Jenis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campuses as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <a href="{{ route('mock.stok_kampus', ['campus' => $c['name']]) }}" class="btn-icon view" title="Lihat Stok Kampus {{ $c['name'] }}" style="width: 34px; height: 34px; border-radius: 50%; background-color: #3182ce; display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        </a>
                    </td>
                    <td style="font-weight: 600; font-size: 14.5px;">{{ $c['name'] }}</td>
                    <td style="font-weight: 700; font-size: 14.5px;">{{ $c['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@else

<!-- DRILL-DOWN MEDICINE LIST FOR SPECIFIC CAMPUS -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="font-size: 18px; font-weight: 700;">Detail Stok Obat - Kampus {{ $selectedCampus }}</h2>
        <p style="font-size: 13px; color: var(--text-muted);">Menampilkan ketersediaan obat khusus di apotek cabang {{ $selectedCampus }}</p>
    </div>
    <a href="{{ route('mock.stok_kampus') }}" class="btn-outline" style="padding: 8px 16px; border-radius: 8px;">
        &larr; Kembali Ke Daftar Kampus
    </a>
</div>

<div class="card" style="padding: 20px; border-radius: 16px;">
    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background-color: #ffffff; color: #1e293b; border-bottom: 2px solid #e2e8f0;">
                    <th style="background: none; color: #1e293b; font-weight: 700; width: 40px;">#</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Nama Obat</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Kemasan</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Kadaluarsa</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Satuan</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Stok Kampus</th>
                    <th style="background: none; color: #1e293b; font-weight: 700;">Status Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $index => $med)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ strtoupper($med->name) }}</td>
                    <td>{{ $med->package ?? 'botol' }}</td>
                    <td>{{ $med->expire_date ? \Carbon\Carbon::parse($med->expire_date)->format('Y-m-d') : '2028-12-31' }}</td>
                    <td>{{ $med->formulation ?? 'Botol' }}</td>
                    <td style="font-weight: 700; color: var(--primary-color);">
                        {{ rand(15, 60) }} {{ $med->formulation ?? 'Botol' }}
                    </td>
                    <td><span class="status-pill available">Tersedia</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

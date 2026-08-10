<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Poliklinik Al-Azhar')</title>
    
    <!-- Favicon link -->
    <link rel="icon" type="image/png" href="{{ asset('poliklinik favicon.png') }}">
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Default state starts expanded (maximized) for seamless child nav experience -->
    <div class="app-container expanded">
        
        <!-- SIDEBAR LEFT (CLICKABLE COLLAPSIBLE) -->
        <aside class="sidebar">
            <!-- Glowing Top Accent & Botanical Bottom Background Art Overlays -->
            <div class="sidebar-top-art"></div>
            <div class="sidebar-art-bg"></div>

            <div class="sidebar-header">
                <div class="logo-container" onclick="toggleSidebar(true)">
                    <img src="{{ asset('poliklinik favicon.png') }}" alt="Poliklinik Al-Azhar Logo">
                    <div class="sidebar-text logo-text-group" style="display: flex; flex-direction: column; line-height: 1.15; text-align: left;">
                        <span style="color: #228781; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Poliklinik</span>
                        <span style="color: #0282C6; font-size: 19px; font-weight: 800; letter-spacing: 0.3px;">Al-Azhar</span>
                    </div>
                </div>
                <!-- Collapse Trigger Button -->
                <button type="button" class="sidebar-collapse-btn" onclick="toggleSidebar(false); event.stopPropagation();" title="Tutup Navigasi">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Enhanced Profile Box -->
            <div class="profile-card">
                <div style="position: relative; display: inline-block;">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=200&auto=format&fit=crop" alt="dr. Siti Rahmawati" class="profile-avatar">
                    <span title="Status: Online & Tugas" style="position: absolute; bottom: 2px; right: 2px; width: 13px; height: 13px; background-color: #22c55e; border: 2px solid #228781; border-radius: 50%;"></span>
                </div>
                <div class="profile-info-text">
                    <h3 class="profile-name">dr. Siti Rahmawati</h3>
                    <span class="profile-role">Super Admin</span>
                    <div style="margin-top: 5px; display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; background: rgba(255, 255, 255, 0.18); border-radius: 12px; font-size: 10.5px; font-weight: 600; color: #ffffff; backdrop-filter: blur(4px);">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background-color: #4ade80;"></span> Praktik Aktif
                    </div>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <nav class="sidebar-nav">
                <span class="nav-category">Main Menu</span>
                
                <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" onclick="expandSidebarOnly()" data-roles="Super Admin,Admin">
                    <!-- Home Solid Icon -->
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                
                <span class="nav-category">Modul Data Pasien</span>
                
                <a href="javascript:void(0)" class="nav-link {{ Route::is('patients.index') || Route::is('patients.show') || Route::is('rme.create') || Route::is('rme.edit') || Route::is('mock.arsip_medis') ? 'active' : '' }}" onclick="toggleSubmenu(this)" data-roles="Super Admin,Admin">
                    <!-- Users Solid Icon -->
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 00-7 7v1h12v-1a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="sidebar-text">Data Pasien</span>
                </a>
                
                <!-- RME Submenu Links -->
                <div class="submenu-list {{ Route::is('patients.index') || Route::is('patients.show') || Route::is('rme.create') || Route::is('rme.edit') || Route::is('mock.arsip_medis') ? 'show' : '' }}" data-parent-roles="Super Admin,Admin">
                    <a href="{{ route('patients.index') }}" class="submenu-link {{ Route::is('patients.index') || Route::is('patients.show') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Daftar Pasien</span>
                    </a>
                    <a href="{{ route('rme.create') }}" class="submenu-link {{ Route::is('rme.create') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Rekam Medis</span>
                    </a>
                    <a href="{{ route('mock.arsip_medis') }}" class="submenu-link {{ Route::is('mock.arsip_medis') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Arsip Medis</span>
                    </a>
                </div>

                <span class="nav-category">Apotek & Logistik</span>
                
                <a href="javascript:void(0)" class="nav-link {{ Route::is('medicines.index') || Route::is('medicines.pengadaan') || Route::is('mock.stok_kampus') || Route::is('mock.permohonan_stok') ? 'active' : '' }}" onclick="toggleSubmenu(this)" data-roles="Super Admin,Admin">
                    <!-- Medicine Bottle Solid Icon -->
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zM6 6a2 2 0 00-2 2v9a2 2 0 002 2h8a2 2 0 002-2V8a2 2 0 00-2-2H6zm2 5a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sidebar-text">Data Obat</span>
                </a>

                <!-- Apotek Submenu Links -->
                <div class="submenu-list {{ Route::is('medicines.index') || Route::is('medicines.pengadaan') || Route::is('mock.stok_kampus') || Route::is('mock.permohonan_stok') ? 'show' : '' }}" data-parent-roles="Super Admin,Admin">
                    <a href="{{ route('medicines.index') }}" class="submenu-link {{ Route::is('medicines.index') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Data Gudang</span>
                    </a>
                    <a href="{{ route('medicines.pengadaan') }}" class="submenu-link {{ Route::is('medicines.pengadaan') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Transaksi Pembelian</span>
                    </a>
                    <a href="{{ route('mock.stok_kampus') }}" class="submenu-link {{ Request::is('obat/stok-kampus') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Stok Kampus</span>
                    </a>
                    <a href="{{ route('mock.permohonan_stok') }}" class="submenu-link {{ Request::is('obat/permohonan-stok') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Permohonan Stok</span>
                    </a>
                </div>

                <span class="nav-category">Rekap Kunjungan</span>

                <a href="javascript:void(0)" class="nav-link {{ Request::is('rekap/*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" data-roles="Super Admin,Admin">
                    <!-- Document Text Icon -->
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2h2v2H6V6zm4 0h2v2h-2V6zm2 4H6v2h6v-2zm-6 4h6v2H6v-2z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sidebar-text">Data Rekap</span>
                </a>
                
                <!-- Rekap Submenus -->
                <div class="submenu-list {{ Request::is('rekap/*') ? 'show' : '' }}" data-parent-roles="Super Admin,Admin">
                    <a href="{{ route('mock.rekap', 'non-pendidikan') }}" class="submenu-link {{ Request::is('rekap/non-pendidikan') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Non Pendidikan</span>
                    </a>
                    <a href="{{ route('mock.rekap', 'pendidikan') }}" class="submenu-link {{ Request::is('rekap/pendidikan') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Pendidikan</span>
                    </a>
                    <a href="{{ route('mock.rekap', 'keluarga-pegawai') }}" class="submenu-link {{ Request::is('rekap/keluarga-pegawai') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Keluarga Pegawai</span>
                    </a>
                    <a href="{{ route('mock.rekap', 'dokter-poli-umum') }}" class="submenu-link {{ Request::is('rekap/dokter-poli-umum') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Dokter Poli Umum</span>
                    </a>
                    <a href="{{ route('mock.rekap', 'dokter-poli-gigi') }}" class="submenu-link {{ Request::is('rekap/dokter-poli-gigi') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Dokter Poli Gigi</span>
                    </a>
                    <a href="{{ route('mock.rekap', 'print-jasa-tindakan') }}" class="submenu-link {{ Request::is('rekap/print-jasa-tindakan') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Print Jasa Tindakan</span>
                    </a>
                    <a href="{{ route('mock.rekap', 'rekap-forsipa') }}" class="submenu-link {{ Request::is('rekap/rekap-forsipa') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Rekap Forsipa</span>
                    </a>
                </div>

                <span class="nav-category">Data Poliklinik</span>
                
                <a href="javascript:void(0)" class="nav-link {{ Route::is('nakes.index') || Route::is('poli.index') ? 'active' : '' }}" onclick="toggleSubmenu(this)" data-roles="Super Admin,Admin">
                    <!-- Master User Icon -->
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 00-7 7v1h12v-1a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="sidebar-text">Data Poliklinik</span>
                </a>
                
                <!-- Master Data Submenu Links -->
                <div class="submenu-list {{ Route::is('nakes.index') || Route::is('poli.index') ? 'show' : '' }}" data-parent-roles="Super Admin,Admin">
                    <a href="{{ route('nakes.index') }}" class="submenu-link {{ Route::is('nakes.index') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Tenaga Kesehatan</span>
                    </a>
                    <a href="{{ route('poli.index') }}" class="submenu-link {{ Route::is('poli.index') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Poli & Layanan</span>
                    </a>
                </div>

                <span class="nav-category" id="master-category">Pengaturan</span>
                
                <a href="javascript:void(0)" class="nav-link {{ Request::is('pengaturan/*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" data-roles="Super Admin">
                    <!-- Settings Gear Icon -->
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.724 1.724 0 01-2.573 1.066c-1.543-.94-3.31.826-2.37 2.37a1.724 1.724 0 01-1.065 2.572c-1.56.38-1.56 2.6 0 2.98a1.724 1.724 0 011.065 2.572c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065.38 1.56 2.6 1.56 2.98 0a1.724 1.724 0 012.573 1.066c1.543.94 3.31-.826 2.37-2.37a1.724 1.724 0 011.065-2.572c1.56-.38 1.56-2.6 0-2.98a1.724 1.724 0 01-1.065-2.572c.94-1.543-.826-3.31-2.37-2.37.996-.608-2.296-.07-2.572 1.065zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sidebar-text">Pengaturan</span>
                </a>

                <!-- Settings Submenus -->
                <div class="submenu-list {{ Request::is('pengaturan/*') ? 'show' : '' }}" data-parent-roles="Super Admin" id="master-submenu">
                    <a href="{{ route('mock.pengaturan', 'pengguna') }}" class="submenu-link {{ Request::is('pengaturan/pengguna') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Data Pengguna</span>
                    </a>
                    <a href="{{ route('mock.pengaturan', 'kampus') }}" class="submenu-link {{ Request::is('pengaturan/kampus') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Data Kampus</span>
                    </a>
                    <a href="{{ route('mock.pengaturan', 'status') }}" class="submenu-link {{ Request::is('pengaturan/status') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Data Status</span>
                    </a>
                    <a href="{{ route('mock.pengaturan', 'unit') }}" class="submenu-link {{ Request::is('pengaturan/unit') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Data Unit</span>
                    </a>
                    <a href="{{ route('mock.pengaturan', 'icd-10') }}" class="submenu-link {{ Request::is('pengaturan/icd-10') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Data ICD 10</span>
                    </a>
                    <a href="{{ route('mock.pengaturan', 'periode') }}" class="submenu-link {{ Request::is('pengaturan/periode') ? 'active' : '' }}">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width: 8px; height: 8px;"><circle cx="10" cy="10" r="5"></circle></svg>
                        <span>Data Periode</span>
                    </a>
                </div>
            </nav>
            
            <!-- Sidebar Footer: Ambulance Call & Logout -->
            <div class="sidebar-footer">
                <div class="emergency-card" onclick="alert('Panggilan Darurat Dikirim ke Layanan Ambulans Utama Poliklinik Al-Azhar!')">
                    <div class="emergency-icon">
                        <!-- Phone Icon -->
                        <svg viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                    </div>
                    <div class="emergency-info">
                        <h4>Ambulance Call</h4>
                        <p>118 / 119</p>
                    </div>
                </div>

                <!-- Keluar Akun (Logout) Button -->
                <button type="button" class="logout-btn" onclick="confirmLogout()">
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="logout-text">Keluar Akun</span>
                </button>
            </div>
        </aside>
        
        <!-- MAIN CONTENT WRAPPER -->
        <div class="main-wrapper">
            
            <!-- HEADER TOP -->
            <header class="header">
                <div class="search-bar">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Cari data pasien, obat, atau rekam medis...">
                </div>
                
                <div class="header-right">
                    <!-- Dynamic Role Switcher (Super Admin & Admin Only) -->
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Akses Peran:</span>
                        <select id="roleSwitcher" class="role-switcher-select" onchange="switchRole(this.value)">
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="language-selector">
                        <img src="https://flagcdn.com/w20/id.png" alt="ID Flag" class="flag-icon">
                        <span>ID</span>
                    </div>
                    
                    <button class="header-icon-btn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </button>
                    
                    <button class="header-icon-btn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        <span class="badge"></span>
                    </button>
                    
                    <div class="user-menu">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=200&auto=format&fit=crop" alt="dr. Siti Rahmawati">
                    </div>
                </div>
            </header>
            
            <!-- MAIN CONTENT AREA -->
            <main class="content-container">
                <!-- Session Alert -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Script Clickable Sidebar & Role Access Switcher -->
    <script>
        function toggleSidebar(forceExpand) {
            const container = document.querySelector('.app-container');
            let expand = true;
            if (forceExpand === true) {
                container.classList.add('expanded');
                expand = true;
            } else if (forceExpand === false) {
                container.classList.remove('expanded');
                expand = false;
            } else {
                container.classList.toggle('expanded');
                expand = container.classList.contains('expanded');
            }
            localStorage.setItem('sidebar_expanded', expand ? 'true' : 'false');
        }

        // Parent triggers dropdown transition dynamically
        function toggleSubmenu(el) {
            const container = document.querySelector('.app-container');
            if (!container.classList.contains('expanded')) {
                container.classList.add('expanded');
                localStorage.setItem('sidebar_expanded', 'true');
            }
            
            const submenu = el.nextElementSibling;
            if (submenu && submenu.classList.contains('submenu-list')) {
                const isOpen = submenu.classList.contains('show');
                if (isOpen) {
                    submenu.classList.remove('show');
                } else {
                    submenu.classList.add('show');
                }
            }
        }

        function expandSidebarOnly() {
            const container = document.querySelector('.app-container');
            if (!container.classList.contains('expanded')) {
                container.classList.add('expanded');
                localStorage.setItem('sidebar_expanded', 'true');
            }
        }

        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar dari akun Poliklinik Al-Azhar?")) {
                alert("Anda berhasil keluar dari sistem!");
                window.location.reload();
            }
        }

        function switchRole(role) {
            localStorage.setItem('selected_role', role);
            applyRole(role);
        }

        function applyRole(role) {
            const switcher = document.getElementById('roleSwitcher');
            if (switcher) switcher.value = role;

            const masterCategory = document.getElementById('master-category');
            const masterSubmenu = document.getElementById('master-submenu');
            const masterNavLink = document.querySelector('a[href*="/pengaturan/"]');

            if (role === 'Super Admin') {
                if (masterCategory) masterCategory.style.display = 'block';
                if (masterSubmenu) {
                    if (masterSubmenu.classList.contains('show')) {
                        masterSubmenu.style.display = 'flex';
                    } else {
                        masterSubmenu.style.display = '';
                    }
                }
                if (masterNavLink) masterNavLink.style.display = 'flex';
            } else {
                if (masterCategory) masterCategory.style.display = 'none';
                if (masterSubmenu) masterSubmenu.style.display = 'none';
                if (masterNavLink) masterNavLink.style.display = 'none';
            }

            const roleLabel = document.querySelector('.profile-role');
            if (roleLabel) {
                roleLabel.textContent = role;
            }
        }

        // Initialize default states on load - EXPANDED BY DEFAULT
        document.addEventListener('DOMContentLoaded', () => {
            const currentRole = localStorage.getItem('selected_role') || 'Super Admin';
            applyRole(currentRole);

            // Default sidebar state: EXPANDED unless explicitly saved as 'false'
            const sidebarState = localStorage.getItem('sidebar_expanded');
            const container = document.querySelector('.app-container');
            if (sidebarState === 'false') {
                container.classList.remove('expanded');
            } else {
                container.classList.add('expanded');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>

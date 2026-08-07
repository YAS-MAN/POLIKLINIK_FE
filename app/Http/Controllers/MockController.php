<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockController extends Controller
{
    public function rekap($type)
    {
        $title = "Rekap Data - " . ucwords(str_replace('-', ' ', $type));
        $description = "Halaman ini menampilkan laporan rekapitulasi data pemeriksaan pasien kelompok " . ucwords(str_replace('-', ' ', $type)) . " pada Poliklinik Al-Azhar.";
        
        $rows = [
            ['Tgl Kunjungan', 'Kode Pasien', 'Nama Pasien', 'Diagnosa', 'Dokter Pemeriksa', 'Tarif Layanan'],
            [now()->format('d/m/Y'), 'A298826', 'Deena Cooley', 'Influenza (J10.1)', 'Dr. Smith Chang', 'Rp 50.000'],
            [now()->subDays(1)->format('d/m/Y'), 'B298726', 'Jerry Wilcox', 'Common Cold (J00)', 'Dr. April Gallegos', 'Rp 75.000'],
            [now()->subDays(3)->format('d/m/Y'), 'C298626', 'Eduardo Kramer', 'Diabetes (E11)', 'Dr. Daren Andrade', 'Rp 120.000'],
        ];

        return view('mock.index', compact('title', 'description', 'rows'));
    }

    public function pengaturan($type)
    {
        $title = "Pengaturan - " . ucwords(str_replace('-', ' ', $type));
        $description = "Pengelolaan parameter konfigurasi sistem untuk data " . ucwords(str_replace('-', ' ', $type)) . ".";

        $rows = [];
        if ($type === 'pengguna') {
            $rows = [
                ['Username', 'Nama Pengguna', 'Email', 'Role', 'Status'],
                ['ema.wilson', 'Dr. Ema Wilson', 'ema.wilson@poliklinik.com', 'Super Admin', 'Aktif'],
                ['admin.poli', 'Admin Poliklinik', 'admin.poli@poliklinik.com', 'Admin', 'Aktif'],
            ];
        } elseif ($type === 'icd10') {
            $rows = [
                ['Kode ICD-10', 'Nama Diagnosa / Penyakit', 'Golongan', 'Keterangan'],
                ['J00', 'Acute nasopharyngitis (common cold)', 'Penyakit Pernafasan', 'Umum'],
                ['J10.1', 'Influenza with other respiratory manifestations', 'Penyakit Pernafasan', 'Menular'],
                ['E11', 'Type 2 diabetes mellitus', 'Penyakit Endokrin', 'Kronis'],
                ['N40', 'Hyperplasia of prostate', 'Penyakit Genitourinaria', 'Lansia'],
            ];
        } else {
            $rows = [
                ['Parameter Key', 'Value', 'Deskripsi / Catatan', 'Terakhir Diubah'],
                ['status_active', 'Aktif', 'Indikator status rekam medis terbuka', now()->format('d/m/Y')],
                ['status_locked', 'Terkunci', 'Indikator status rekam medis selesai', now()->format('d/m/Y')],
                ['periode_aktif', '2026/Ganjil', 'Periode pemeriksaan akademik berjalan', now()->format('d/m/Y')],
            ];
        }

        return view('mock.index', compact('title', 'description', 'rows'));
    }

    public function obatMock($type)
    {
        $title = "Data Obat - " . ucwords(str_replace('-', ' ', $type));
        $description = "Logistik dan distribusi obat untuk area " . ucwords(str_replace('-', ' ', $type)) . ".";

        $rows = [
            ['Kode Barang', 'Nama Obat', 'Jumlah Stok', 'Gudang Asal', 'Status Permintaan'],
            ['OBT-001', 'Paracetamol 500mg', '250 Tablet', 'Gudang Pusat', 'Selesai'],
            ['OBT-004', 'Ventolin Inhaler', '12 Inhaler', 'Gudang Kampus', 'Proses Pengiriman'],
        ];

        return view('mock.index', compact('title', 'description', 'rows'));
    }

    public function arsipMedis()
    {
        $title = "Arsip Medis";
        $description = "Penyimpanan data riwayat arsip rekam medis lama pasien Poliklinik Al-Azhar.";

        $rows = [
            ['Tgl Pemeriksaan', 'No. Rekam Medis', 'Nama Pasien', 'Diagnosa Utama', 'Poli Asal', 'Status Arsip'],
            ['12/01/2025', 'A298826', 'Deena Cooley', 'Gastritis (K29.7)', 'Poli Umum', 'Tersimpan Digital'],
            ['05/03/2025', 'B298726', 'Jerry Wilcox', 'Hypertensive Heart Disease (I11)', 'Poli Gigi', 'Tersimpan Digital'],
        ];

        return view('mock.index', compact('title', 'description', 'rows'));
    }
}

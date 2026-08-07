2026 



# Business Requirement Document 

APLIKASI POLIKLINIK VERSI 1.0 DIREKTORAT TI DAN TRANSFORMASI DIGITAL 

|Judul Dokumen|Business Requirements Document (BRD) Aplikasi Poliklinik|
|---|---|
|Versi|1.0|
|Tanggal|20 Agustus 2026|
|Disusun|Direktorat TI dan Transformasi Digital|



## **1. Pendahuluan** 

Dokumen Business Requirements Document (BRD) ini disusun sebagai acuan formal dalam pengembangan Aplikasi Poliklinik yang mencakup modul Rekam Medis Elektronik (RME), Data Master, dan Pengadaan Obat. Dokumen ini mendefinisikan kebutuhan bisnis, proses operasional, serta spesifikasi sistem yang diharapkan oleh pemangku kepentingan. 

YPI Al Azhar merupakan wadah yang tidak hanya berfokus pada pembinaan akademik dan karakter, tetapi juga menjamin kesejahteraan kesehatan seluruh elemen yang berada di dalamnya murid/siswa, tenaga pendidik, staf, hingga keluarga besar YPI Al Azhar. Pengelolaan poliklinik saat ini masih menggunakan pencatatan konvensional dan terpisahpisah, pencatatan manual memiliki berbagai kendala operasional: pencarian riwayat kesehatan memakan waktu lama, risiko kehilangan atau kerusakan dokumen fisik, terjadi duplikasi data pasien, pemantauan persediaan obat hingga pelaporan menjadi lambat dan kurang akurat. Selain itu, belum tersedianya sistem yang terintegrasi membuat pelayanan medis tidak dapat berjalan secepat dan seefisien yang diharapkan. 

- 1.1. Tujuan 

   - Menyediakan sistem penyimpanan rekam medis yang terpusat, rapi, dan mudah diakses oleh pihak yang berwenang. 

   - Menstandarisasi pengelolaan data dasar poliklinik agar seluruh bagian menggunakan referensi data yang sama. 

   - Mengotomatiskan proses perencanaan, permintaan, penerimaan, hingga pencatatan pengadaan obat untuk mencegah kekurangan atau kelebihan stok. 

   - Meminimalkan kesalahan pencatatan dan kerusakan dokumen. 

   - Menghasilkan laporan yang akurat dan tepat waktu untuk kebutuhan manajemen. 

- 1.2. Ruang Lingkup 

   - 1.2.1. Lingkup Pekerjaan 

      - **Modul Rekam Medis** : Pendaftaran pasien, riwayat pemeriksaan, diagnosa, tindakan medis, resep obat, dan riwayat kunjungan. 

      - **Modul Data Master** : Data pasien, dokter, tenaga medis, poli/unit pelayanan, obat, satuan, jenis tindakan, dan tarif layanan. 

      - **Modul Obat** : Perencanaan kebutuhan, permintaan penawaran, pemilihan penyedia, penerimaan barang, pencatatan pembelian, dan pemantauan stok. 

      - **Pengguna sistem** : Petugas pendaftaran, dokter, apoteker, petugas gudang obat, manajemen, dan admin sistem. 

      - **Laporan** operasional dan manajerial terkait ketiga modul utama. 

   - 1.2.2. Tidak Termasuk dalam Lingkup Pekerjaan 

- Modul pembayaran dan kasir 

- Modul asuransi dan klaim jaminan Kesehatan 

- Pengelolaan gaji dan kepegawaian 

- Integrasi dengan peralatan medis khusus. 

- Pengelolaan inventaris barang selain obat-obatan 

## **2. Proses Bisnis Yang Diharapkan** 

|Proses Bisnis|Alur Kegiatan|
|---|---|
|1. <sup>**Pendaftaran &**</sup><br>**Rekam Medis**|Pasien mendaftar→Petugas memeriksa data pasien (baru/lama)→Dibuatkan<br>nomor rekam medis→Pasien menuju poli yang dituju→Dokter memeriksa<br>dan mencatat diagnosa, tindakan, resep→Data tersimpan secara otomatis|
|2. <sup>**Pengelolaan Data**</sup><br>**Master**|Admin memasukkan/memperbarui data dasar→Data diverifikasi→Disimpan<br>sebagai referensi standar yang digunakan seluruh modul|



Pemantauan stok minimum → Dibuat usulan pengadaan → Disetujui pimpinan 3. **Pengadaan Obat** → Dilakukan pemilihan penyedia → Pesanan dibuat → Barang diterima dan diperiksa → Dicatat masuk ke sistem → Stok diperbarui secara otomatis 

## **3. Kebutuhan Fungsional** 

- 2.1. Modul Rekam Medis 

   - Membuat, melihat, mengubah, dan menutup data rekam medis pasien 

   - Pencarian rekam medis berdasarkan nomor, nama, atau tanggal kunjungan 

   - Mencatat riwayat keluhan, pemeriksaan fisik, diagnosa ICD-10, tindakan medis, dan resep obat 

   - Menampilkan riwayat kunjungan dan pengobatan pasien secara lengkap 

- Mencetak lembar rekam medis, resep, dan surat keterangan kesehatan 

- 2.2. Modul Data Master 

   - Pengelolaan data pasien: Nama, alamat, tanggal lahir, kontak, riwayat alergi, dan riwayat penyakit. 

   - Pengelolaan data tenaga kesehatan: Data pribadi, poli tempat bertugas, dan status praktik. 

   - Pengelolaan data obat: Nama generik/dagang, golongan, bentuk sediaan, kandungan, aturan pakai, dan batas kadaluarsa. 

   - Pengelolaan data poli, tarif layanan, satuan ukur, dan jenis tindakan medis. 

- Pengaturan hak akses pengguna system. 

- 2.3. Modul Pengadaan Obat 

   - Pencatatan stok awal dan stok masuk dari pengadaan. 

   - Peringatan otomatis jika stok mendekati batas minimum atau obat mendekati kadaluarsa. 

   - Pembuatan usulan pengadaan berdasarkan kebutuhan dan stok yang ada. 

   - Pencatatan data penyedia obat, pesanan, dan bukti penerimaan barang. 

   - Pencatatan harga beli dan riwayat transaksi pengadaan. 

   - Pemantauan pergerakan stok obat masuk dan keluar. 

## **4. Kebutuhan Non-Fungsional (Non-Functional Requirements)** 

|Aspek|Kebutuhan|
|---|---|
|1 Kinerja|Waktu respon pencarian data maksimal 3 detik; dapat digunakan minimal 20 pengguna<br>secara bersamaan|
|2 Kegunaan|Tampilan mudah dipahami, menu disusun sesuai alur kerja, dan tersedia panduan<br>penggunaan|
|3 Portabilitas|Dapat diakses melalui komputer desktop|





<!-- Start of picture text -->
1. PENDAFTARAN 2. DATA PASIEN & 3. PEMERIKSAAN 4. RESEP & TINDAKAN<br>REKAM MEDIS DOKTER<br>ea<br>__\— Re<br>—— C—)<br>= fr<br>wey<br>Pasien melakukan Data pasien dibuat/diupdate Dokter melakukan pemeriksaan Dokter membuat resep obat<br>pendaftaran dan rekam medis dibuka dan menentukan diagnosa dan/atau tindakan<br><!-- End of picture text -->



<!-- Start of picture text -->
1. RESEP OBAT 2. PENGURANGAN 3. PEMANTAUAN 4. USULAN 5. PENERIMAAN 6. PEMBARUAN<br>STOK STOK PENGADAAN OBAT STOK<br>—<br>Dokter membuat Obat diberikan ke pasien, Sistem memantau stok Petugas membuat usulan Obat diterima dari Sistem memperbarui<br>resep obat untuk sistem mengurangi dan memberikan notifikasi pengadaan berdasarkan supplier dan dicatat stok sesuai jumlah obat<br>pasien stok otomatis jika stok menipis stok minimum ke sistem yang diterima<br><!-- End of picture text -->

## **8. Risiko dan Mitigasi** 

|Risiko|Probabilitas|Dampak|Mitigasi|
|---|---|---|---|
|1. <sup>Pengguna belum terbiasa</sup><br>menggunakan sistem|Tinggi|Sedang|Memberikan pelatihan menyeluruh dan<br>panduan tertulis; masa pendampingan<br>setelah sistem berjalan|
|2. <sup>Gangguan sistem yang menghambat</sup><br>pelayanan|Rendah|Tinggi|Menyediakan prosedur sementara jika<br>sistem terganggu; pemeliharaan berkala|
|3. Kehilangan atau kerusakan data|Rendah|Sangat<br>Tinggi|Pencadangan data berkala; uji coba<br>pemulihan data secara berkala|
|4. <sup>Akses data oleh pihak yang tidak</sup><br>berwenang|Rendah|Sangat<br>Tinggi|Pengaturan hak akses ketat; penggantian<br>kata sandi berkala; pemantauan aktivitas<br>akses|
|5. <sup>Keterlambatan proses pengadaan</sup><br>obat<br>**Estimasi Biaya Pengembangan**|Sedang|Tinggi|Peringatan stok minimum; prosedur<br>persetujuan yang cepat dan jelas|
|Komponen Biaya|Keterangan||Estimasi Biaya|
|1 Pengembangan Aplikasi|Analisis, peran|cangan, pe|mbuatan, dan pengujian<br>45.000.000|
|2 Infrastruktur & Perangkat Lunak|Server, lisensi|sistem ope|rasi, dan basis data<br>15.000.000|
|3 Pelatihan Pengguna|Pelatihan petu|gas operas|ional dan admin<br>5.000.000|
|4 Implementasi & Konversi Data|Memindahkan|data lama|ke sistem baru<br>7.500.000|
|5 Dukungan Pasca Peluncuran|Pemeliharaan|selama 3 b|ulan pertama<br>7.500.000|
|**Total Estimasi**<br>**Rencana Implementasi**|||**Rp 80.000.000**|
|Tahap<br>Kegiatan|||Waktu Pelaksanaan|
|1.<br>Penyempurnaan kebutuhan d|an perancanga|n sistem|Minggu ke-1 s.d ke-2|
|2.<br>Pembuatan dan pengkodean|aplikasi||Minggu ke-3 s.d ke-8|
|3.<br>Pengujian sistem dan perbai|kan kesalahan||Minggu ke-9 s.d ke-10|
|4.<br>Pelatihan pengguna dan pem|indahan data||Minggu ke-11 s.d ke-12|
|5.<br>Peluncuran sistem secara be|rtahap||Minggu ke-13|
|6.<br>Pendampingan dan pemanta|uan pasca pelu|ncuran|Minggu ke-14 s.d ke-24|



## **9. Estimasi Biaya Pengembangan** 

## **10. Rencana Implementasi** 

## **11. Persetujuan** 

Dokumen ini disusun sebagai acuan utama pengembangan Aplikasi Poliklinik. Persetujuan dari pihak terkait menjadi tanda sah untuk memulai tahap pelaksanaan. 



<!-- Start of picture text -->
Jakarta,  20 Mei 2026<br>Ka. Bagian TI dan<br>Ka. Bagian Kepegawaian<br>Transformasi Digital<br>( ………………………………………………………..)  ( ………………………………………………………..)<br><!-- End of picture text -->


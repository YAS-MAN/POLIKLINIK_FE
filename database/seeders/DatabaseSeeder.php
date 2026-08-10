<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Procurement;
use App\Models\Poli;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User - Authentic Indonesian Name
        User::create([
            'name' => 'dr. Siti Rahmawati, Sp.PD',
            'email' => 'siti.rahmawati@poliklinik-alazhar.ac.id',
            'password' => Hash::make('password'),
        ]);

        // 2. Seed Polis (Departemen Poliklinik)
        Poli::create(['name' => 'Poli Umum', 'code' => 'PLU', 'base_tariff' => 50000.00]);
        Poli::create(['name' => 'Poli Gigi & Mulut', 'code' => 'PLG', 'base_tariff' => 75000.00]);
        Poli::create(['name' => 'Poli Anak', 'code' => 'PLA', 'base_tariff' => 90000.00]);
        Poli::create(['name' => 'Poli Jantung & Pembuluh Darah', 'code' => 'PLJ', 'base_tariff' => 150000.00]);
        Poli::create(['name' => 'Poli Penyakit Dalam', 'code' => 'PPD', 'base_tariff' => 120000.00]);

        // 3. Seed Doctors (Tenaga Kesehatan Indonesia)
        $doc1 = Doctor::create(['name' => 'dr. Rizky Ramadhan, Sp.JP', 'specialty' => 'Spesialis Jantung', 'department' => 'Poli Jantung', 'status' => 'Available', 'avatar_url' => 'smith_chang.jpg']);
        $doc2 = Doctor::create(['name' => 'dr. Budi Santoso, Sp.OT', 'specialty' => 'Spesialis Ortopedi', 'department' => 'Poli Bedah Tulang', 'status' => 'Available', 'avatar_url' => 'dmitriy_groshev.jpg']);
        $doc3 = Doctor::create(['name' => 'dr. Lilis Suryani, Sp.KK', 'specialty' => 'Spesialis Kulit & Kelamin', 'department' => 'Poli Kulit', 'status' => 'Not Available', 'avatar_url' => 'sheryl_glass.jpg']);
        $doc4 = Doctor::create(['name' => 'dr. Tri Wahyuni, Sp.N', 'specialty' => 'Spesialis Saraf (Neurologi)', 'department' => 'Poli Saraf', 'status' => 'Available', 'avatar_url' => 'gabriela_tyler.jpg']);
        $doc5 = Doctor::create(['name' => 'dr. Bambang Prasetyo, Sp.M', 'specialty' => 'Spesialis Mata', 'department' => 'Poli Mata', 'status' => 'Available', 'avatar_url' => 'lilly_chavez.jpg']);
        
        // Consulting Doctors for Patients table
        $doc6 = Doctor::create(['name' => 'dr. Joko Widodo, Sp.B', 'specialty' => 'Spesialis Bedah Umum', 'department' => 'Poli Bedah', 'status' => 'Available', 'avatar_url' => 'vicki_walsh.jpg']);
        $doc7 = Doctor::create(['name' => 'dr. Dewi Lestari, Sp.OG', 'specialty' => 'Spesialis Kebidanan & Kandungan', 'department' => 'Poli KIA/Kandungan', 'status' => 'Available', 'avatar_url' => 'april_gallegos.jpg']);
        $doc8 = Doctor::create(['name' => 'dr. Hendra Wijaya, Sp.KJ', 'specialty' => 'Spesialis Kedokteran Jiwa', 'department' => 'Poli Psikiatri', 'status' => 'Available', 'avatar_url' => 'basil_frost.jpg']);
        $doc9 = Doctor::create(['name' => 'dr. Anisa Putri, Sp.KG', 'specialty' => 'Spesialis Konservasi Gigi', 'department' => 'Poli Gigi', 'status' => 'Available', 'avatar_url' => 'nannie_guerrero.jpg']);
        $doc10 = Doctor::create(['name' => 'dr. Ahmad Fauzi, Sp.A', 'specialty' => 'Spesialis Kesehatan Anak', 'department' => 'Poli Anak', 'status' => 'Available', 'avatar_url' => 'daren_andrade.jpg']);

        // 4. Seed Patients (Pasien Bahasa Indonesia)
        $pat1 = Patient::create([
            'name' => 'Ahmad Subagja',
            'nik' => '3171012345670001',
            'patient_type' => 'Murid',
            'patient_code' => 'A298826',
            'date_of_birth' => '2012-05-12', // Student
            'gender' => 'Male',
            'phone' => '08123456789',
            'address' => 'Jl. Kebagusan Dalam No. 15, Jakarta Selatan',
            'allergies' => 'Penisilin, Telur',
            'medical_history' => 'Hipertensi Ringan, Asma Bronkial'
        ]);

        $pat2 = Patient::create([
            'name' => 'Siti Aminah',
            'nik' => '3171012345670002',
            'patient_type' => 'Pegawai',
            'patient_code' => 'B298726',
            'date_of_birth' => '1985-08-20', // Staff
            'gender' => 'Female',
            'phone' => '08129876543',
            'address' => 'Jl. Pahlawan Komplek YPI Al-Azhar No. 42, Kebayoran Baru',
            'allergies' => 'Tidak Ada',
            'medical_history' => 'Asam Urat (Gout)'
        ]);

        $pat3 = Patient::create([
            'name' => 'Rahmat Hidayat',
            'nik' => '3171012345670003',
            'patient_type' => 'Keluarga Pegawai',
            'patient_code' => 'C298626',
            'date_of_birth' => '1978-01-15',
            'gender' => 'Male',
            'phone' => '08134567890',
            'address' => 'Jl. Darmo Permai No. 8, Jakarta Barat',
            'allergies' => 'Obat Sulfa',
            'medical_history' => 'Penyakit Ginjal Kronis'
        ]);

        $pat4 = Patient::create([
            'name' => 'Nurul Hidayati',
            'nik' => '3171012345670004',
            'patient_type' => 'Forsipa',
            'patient_code' => 'D298526',
            'date_of_birth' => '1990-07-22',
            'gender' => 'Female',
            'phone' => '08151234567',
            'address' => 'Jl. Pemuda No. 12, Kebayoran Lama, Jakarta',
            'allergies' => 'Tidak Ada',
            'medical_history' => 'Maag Akut / Gastritis'
        ]);

        $pat5 = Patient::create([
            'name' => 'Dede Kurniawan',
            'nik' => '3171012345670005',
            'patient_type' => 'Umum',
            'patient_code' => 'E298426',
            'date_of_birth' => '1993-11-03',
            'gender' => 'Male',
            'phone' => '08168901234',
            'address' => 'Jl. Cilandak KKO No. 5, Jakarta Selatan',
            'allergies' => 'Aspirin',
            'medical_history' => 'Kolesterol Tinggi (Hiperlipidemia)'
        ]);

        // 5. Seed Medical Records (Rekam Medis Elektronik RME)
        MedicalRecord::create([
            'patient_id' => $pat1->id,
            'doctor_id' => $doc6->id, // dr. Joko Widodo
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '09:30 WIB',
            'complaints' => 'Nyeri tajam di perut kanan bawah, mual dan nafsu makan menurun',
            'physical_check' => 'TD: 120/80 mmHg, Suhu: 38.2 C, Nyeri tekan di titik McBurney',
            'diagnosis' => 'K35.8 Apendisitis Akut (Usus Buntu)',
            'action_taken' => 'Rujukan tindakan bedah dan pemberian infus cairan RL',
            'prescription_notes' => 'Ceftriaxone Inj 1g, Paracetamol Tablet 500mg (3x1 sesudah makan)',
            'disease' => 'Usus Buntu',
            'status' => 'Closed'
        ]);

        MedicalRecord::create([
            'patient_id' => $pat2->id,
            'doctor_id' => $doc7->id, // dr. Dewi Lestari
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '09:45 WIB',
            'complaints' => 'Demam tinggi 3 hari, tenggorokan sakit saat menelan, dan badan pegal',
            'physical_check' => 'TD: 120/75 mmHg, Suhu: 39.1 C, Faring hiperemis (kemerahan)',
            'diagnosis' => 'J10.1 Influenza dengan Gejala Saluran Napas Akut',
            'action_taken' => 'Edukasi istirahat total, hidrasi air putih, dan pemberian obat antivirus',
            'prescription_notes' => 'Oseltamivir 75mg 2x1 (5 hari), Paracetamol 500mg 3x1',
            'disease' => 'Demam Flu',
            'status' => 'Draft'
        ]);

        MedicalRecord::create([
            'patient_id' => $pat3->id,
            'doctor_id' => $doc8->id, // dr. Hendra Wijaya
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '10:00 WIB',
            'complaints' => 'Hidung tersumbat, batuk berdahak, dan kepala terasa berat',
            'physical_check' => 'TD: 130/85 mmHg, Suhu: 36.8 C, Paru-paru vesikuler normal',
            'diagnosis' => 'J00 Nasofaringitis Akut (Flu Batuk)',
            'action_taken' => 'Terapi suportif dan istirahat secukupnya',
            'prescription_notes' => 'Vitamin C 500mg 1x1, Cetirizine HCI 10mg 1x1 malam',
            'disease' => 'Batuk Pilek',
            'status' => 'Closed'
        ]);

        MedicalRecord::create([
            'patient_id' => $pat4->id,
            'doctor_id' => $doc9->id, // dr. Anisa Putri
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '10:15 WIB',
            'complaints' => 'Perut kembung, sering perih di ulu hati setelah makan pedas',
            'physical_check' => 'TD: 115/75 mmHg, Suhu: 36.5 C, Nyeri tekan epigastrium',
            'diagnosis' => 'K29.7 Gastritis Akut (Sakit Maag)',
            'action_taken' => 'Edukasi pola makan teratur dan menghindari makanan asam/pedas',
            'prescription_notes' => 'Antasida Doen Tablet Kunyah 3x1 (sebelum makan), Omeprazole 20mg 2x1',
            'disease' => 'Gastritis/Maag',
            'status' => 'Draft'
        ]);

        MedicalRecord::create([
            'patient_id' => $pat5->id,
            'doctor_id' => $doc10->id, // dr. Ahmad Fauzi
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '10:30 WIB',
            'complaints' => 'Sesak napas dan dada terasa berat menggelekik setelah olahraga',
            'physical_check' => 'TD: 118/75 mmHg, terdengar suara Mengi (Wheezing) di kedua lapang paru',
            'diagnosis' => 'J45 Asma Bronkial Eksaserbasi Akut',
            'action_taken' => 'Tindakan Nebulizer Ventolin 1 respon di klinik',
            'prescription_notes' => 'Salbutamol Inhaler 100mcg (PRN), Symbicort 160/4.5 2x2 semprot',
            'disease' => 'Asma Bronkial',
            'status' => 'Closed'
        ]);

        // 6. Seed Medicines (Obat-obatan Apotek Indonesia)
        $med1 = Medicine::create([
            'name' => 'Paracetamol 500mg Tablet',
            'generic_name' => 'Paracetamol',
            'category' => 'Analgesik / Anti Demam',
            'formulation' => 'Tablet',
            'dosage_rule' => '3x1 sesudah makan',
            'stock' => 120,
            'min_stock' => 20,
            'expire_date' => '2028-12-31',
            'purchase_price' => 500.00
        ]);

        $med2 = Medicine::create([
            'name' => 'Amoxicillin Trihydrate 500mg',
            'generic_name' => 'Amoxicillin',
            'category' => 'Antibiotik Sistemik',
            'formulation' => 'Kaplet',
            'dosage_rule' => '3x1 sesudah makan (wajib dihabiskan)',
            'stock' => 45,
            'min_stock' => 15,
            'expire_date' => '2027-06-30',
            'purchase_price' => 1500.00
        ]);

        $med3 = Medicine::create([
            'name' => 'Metformin HCI 500mg',
            'generic_name' => 'Metformin HCI',
            'category' => 'Antidiabetes Oral',
            'formulation' => 'Tablet',
            'dosage_rule' => '2x1 bersama makan',
            'stock' => 8, // Stok Kritis!
            'min_stock' => 20,
            'expire_date' => '2027-10-15',
            'purchase_price' => 800.00
        ]);

        $med4 = Medicine::create([
            'name' => 'Ventolin Inhaler 100mcg',
            'generic_name' => 'Salbutamol Albuterol',
            'category' => 'Bronkodilator (Pelega Asma)',
            'formulation' => 'Inhaler',
            'dosage_rule' => '2 semprot bila sesak (PRN)',
            'stock' => 5, // Stok Kritis!
            'min_stock' => 10,
            'expire_date' => '2026-11-20',
            'purchase_price' => 45000.00
        ]);

        $med5 = Medicine::create([
            'name' => 'Vitamin C & Zinc Supplemen',
            'generic_name' => 'Asam Askorbat',
            'category' => 'Vitamin & Suplemen Daya Tahan',
            'formulation' => 'Tablet',
            'dosage_rule' => '1x1 tablet sehari',
            'stock' => 250,
            'min_stock' => 50,
            'expire_date' => '2029-01-01',
            'purchase_price' => 300.00
        ]);

        // 7. Seed Procurements (Transaksi Pengadaan Obat)
        Procurement::create([
            'medicine_id' => $med3->id,
            'supplier_name' => 'PT. Kimia Farma Trading & Distribution',
            'quantity' => 100,
            'order_date' => now()->subDays(2)->toDateString(),
            'status' => 'Approved',
        ]);

        Procurement::create([
            'medicine_id' => $med4->id,
            'supplier_name' => 'PT. Kalbe Farma Tbk',
            'quantity' => 30,
            'order_date' => now()->toDateString(),
            'status' => 'Proposed',
        ]);
    }
}

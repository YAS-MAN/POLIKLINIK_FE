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
        // 1. Seed Admin User
        User::create([
            'name' => 'Dr. Ema Wilson',
            'email' => 'ema.wilson@poliklinik.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Seed Polis (Departemen Poliklinik)
        Poli::create(['name' => 'Poli Umum', 'code' => 'PLU', 'base_tariff' => 50000.00]);
        Poli::create(['name' => 'Poli Gigi', 'code' => 'PLG', 'base_tariff' => 75000.00]);
        Poli::create(['name' => 'Poli Anak', 'code' => 'PLA', 'base_tariff' => 90000.00]);
        Poli::create(['name' => 'Poli Jantung', 'code' => 'PLJ', 'base_tariff' => 150000.00]);
        Poli::create(['name' => 'Poli Penyakit Dalam', 'code' => 'PPD', 'base_tariff' => 120000.00]);

        // 3. Seed Doctors
        $doc1 = Doctor::create(['name' => 'Dr. Smith Chang', 'specialty' => 'Cardiology', 'department' => 'Cardiologist', 'status' => 'Available', 'avatar_url' => 'smith_chang.jpg']);
        $doc2 = Doctor::create(['name' => 'Dr. Dmitriy Groshev', 'specialty' => 'Orthopedics', 'department' => 'Orthopedic', 'status' => 'Available', 'avatar_url' => 'dmitriy_groshev.jpg']);
        $doc3 = Doctor::create(['name' => 'Dr. Sheryl Glass', 'specialty' => 'Dermatology', 'department' => 'Dermatologist', 'status' => 'Not Available', 'avatar_url' => 'sheryl_glass.jpg']);
        $doc4 = Doctor::create(['name' => 'Dr. Gabriela Tyler', 'specialty' => 'Neurology', 'department' => 'Neurologist', 'status' => 'Available', 'avatar_url' => 'gabriela_tyler.jpg']);
        $doc5 = Doctor::create(['name' => 'Dr. Lilly Chavez', 'specialty' => 'Ophthalmology', 'department' => 'Ophthalmologist', 'status' => 'Available', 'avatar_url' => 'lilly_chavez.jpg']);
        
        // Consulting Doctors for Patients table
        $doc6 = Doctor::create(['name' => 'Dr. Vicki Walsh', 'specialty' => 'Surgery', 'department' => 'Surgeon', 'status' => 'Available', 'avatar_url' => 'vicki_walsh.jpg']);
        $doc7 = Doctor::create(['name' => 'Dr. April Gallegos', 'specialty' => 'Gynecology', 'department' => 'Gynecologist', 'status' => 'Available', 'avatar_url' => 'april_gallegos.jpg']);
        $doc8 = Doctor::create(['name' => 'Dr. Basil Frost', 'specialty' => 'Psychiatry', 'department' => 'Psychiatrist', 'status' => 'Available', 'avatar_url' => 'basil_frost.jpg']);
        $doc9 = Doctor::create(['name' => 'Dr. Nannie Guerrero', 'specialty' => 'Urology', 'department' => 'Urologist', 'status' => 'Available', 'avatar_url' => 'nannie_guerrero.jpg']);
        $doc10 = Doctor::create(['name' => 'Dr. Daren Andrade', 'specialty' => 'Cardiology', 'department' => 'Cardiologist', 'status' => 'Available', 'avatar_url' => 'daren_andrade.jpg']);

        // 4. Seed Patients
        $pat1 = Patient::create([
            'name' => 'Deena Cooley',
            'nik' => '3171012345670001',
            'patient_type' => 'Murid',
            'patient_code' => 'A298826',
            'date_of_birth' => '1961-05-12', // 65 y.o.
            'gender' => 'Female',
            'phone' => '08123456789',
            'address' => 'Jl. Kebagusan Dalam, Jakarta Selatan',
            'allergies' => 'Penicillin',
            'medical_history' => 'Hypertension, Diabetes Type 2'
        ]);

        $pat2 = Patient::create([
            'name' => 'Jerry Wilcox',
            'nik' => '3171012345670002',
            'patient_type' => 'Pegawai',
            'patient_code' => 'B298726',
            'date_of_birth' => '1953-08-20', // 73 y.o.
            'gender' => 'Male',
            'phone' => '08129876543',
            'address' => 'Jl. Pahlawan No. 42, Bandung',
            'allergies' => 'None',
            'medical_history' => 'Gout'
        ]);

        $pat3 = Patient::create([
            'name' => 'Eduardo Kramer',
            'nik' => '3171012345670003',
            'patient_type' => 'Keluarga Pegawai',
            'patient_code' => 'C298626',
            'date_of_birth' => '1942-01-15', // 84 y.o.
            'gender' => 'Male',
            'phone' => '08134567890',
            'address' => 'Jl. Darmo Permai, Surabaya',
            'allergies' => 'Sulfa drugs',
            'medical_history' => 'Chronic Kidney Disease'
        ]);

        $pat4 = Patient::create([
            'name' => 'Jason Compton',
            'nik' => '3171012345670004',
            'patient_type' => 'Forsipa',
            'patient_code' => 'D298526',
            'date_of_birth' => '1970-07-22', // 56 y.o.
            'gender' => 'Male',
            'phone' => '08151234567',
            'address' => 'Jl. Pemuda No. 12, Semarang',
            'allergies' => 'None',
            'medical_history' => 'Mild Asthma'
        ]);

        $pat5 = Patient::create([
            'name' => 'Emmitt Bryan',
            'nik' => '3171012345670005',
            'patient_type' => 'Umum',
            'patient_code' => 'E298426',
            'date_of_birth' => '1977-11-03', // 49 y.o.
            'gender' => 'Male',
            'phone' => '08168901234',
            'address' => 'Jl. Malioboro No. 5, Yogyakarta',
            'allergies' => 'Aspirin',
            'medical_history' => 'Hyperlipidemia, Asthma'
        ]);

        // 5. Seed Medical Records (RME)
        MedicalRecord::create([
            'patient_id' => $pat1->id,
            'doctor_id' => $doc6->id, // Vicki Walsh
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '9:30 AM',
            'complaints' => 'Pain in lower right abdomen, nausea',
            'physical_check' => 'BP: 130/80 mmHg, Temp: 38.2 C, McBurney Point tenderness',
            'diagnosis' => 'K35.8 Acute appendicitis',
            'action_taken' => 'Surgical referral and IV Fluids',
            'prescription_notes' => 'Ceftriaxone 1g IV, Paracetamol 500mg (as needed)',
            'disease' => 'Diabetes',
            'status' => 'Closed' // This record is locked
        ]);

        MedicalRecord::create([
            'patient_id' => $pat2->id,
            'doctor_id' => $doc7->id, // April Gallegos
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '9:45 AM',
            'complaints' => 'High fever, sore throat, and muscle aches',
            'physical_check' => 'BP: 120/75 mmHg, Temp: 39.1 C, Throat redness',
            'diagnosis' => 'J10.1 Influenza with other respiratory manifestations',
            'action_taken' => 'Rest, hydration, and medication',
            'prescription_notes' => 'Oseltamivir 75mg 2x1 (5 days), Paracetamol 500mg 3x1',
            'disease' => 'Fever',
            'status' => 'Draft' // This record is editable
        ]);

        MedicalRecord::create([
            'patient_id' => $pat3->id,
            'doctor_id' => $doc8->id, // Basil Frost
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '10:00 AM',
            'complaints' => 'Runny nose, coughing, and mild headache',
            'physical_check' => 'BP: 140/90 mmHg, Temp: 36.8 C, Lungs clear',
            'diagnosis' => 'J00 Acute nasopharyngitis (common cold)',
            'action_taken' => 'Rest and supportive therapy',
            'prescription_notes' => 'Vitamin C 500mg 1x1, Cetirizine 10mg 1x1',
            'disease' => 'Cold',
            'status' => 'Closed'
        ]);

        MedicalRecord::create([
            'patient_id' => $pat4->id,
            'doctor_id' => $doc9->id, // Nannie Guerrero
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '10:15 AM',
            'complaints' => 'Frequent urination, weak urine stream, nocturia',
            'physical_check' => 'BP: 125/80 mmHg, DRE performed',
            'diagnosis' => 'N40 Hyperplasia of prostate',
            'action_taken' => 'Ordered ultrasound and kidney function test',
            'prescription_notes' => 'Tamsulosin 0.4mg 1x1 (night)',
            'disease' => 'Prostate',
            'status' => 'Draft'
        ]);

        MedicalRecord::create([
            'patient_id' => $pat5->id,
            'doctor_id' => $doc10->id, // Daren Andrade
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '10:30 AM',
            'complaints' => 'Shortness of breath and wheezing after exercise',
            'physical_check' => 'BP: 118/75 mmHg, Wheezing heard in both lung fields',
            'diagnosis' => 'J45 Asthma',
            'action_taken' => 'Nebulizer treatment (Albuterol) in clinic',
            'prescription_notes' => 'Albuterol Inhaler (PRN), Symbicort 160/4.5 2x2',
            'disease' => 'Asthma',
            'status' => 'Closed'
        ]);

        // 6. Seed Medicines
        $med1 = Medicine::create([
            'name' => 'Paracetamol 500mg',
            'generic_name' => 'Paracetamol',
            'category' => 'Analgesic / Antipyretic',
            'formulation' => 'Tablet',
            'dosage_rule' => '3x1 after meal',
            'stock' => 85,
            'min_stock' => 20,
            'expire_date' => '2028-12-31',
            'purchase_price' => 500.00
        ]);

        $med2 = Medicine::create([
            'name' => 'Amoxicillin 500mg',
            'generic_name' => 'Amoxicillin',
            'category' => 'Antibiotic',
            'formulation' => 'Tablet',
            'dosage_rule' => '3x1 after meal (must finish)',
            'stock' => 40,
            'min_stock' => 15,
            'expire_date' => '2027-06-30',
            'purchase_price' => 1500.00
        ]);

        $med3 = Medicine::create([
            'name' => 'Metformin 500mg',
            'generic_name' => 'Metformin HCl',
            'category' => 'Antidiabetic',
            'formulation' => 'Tablet',
            'dosage_rule' => '2x1 with or after meal',
            'stock' => 8, // Below Min Stock!
            'min_stock' => 20,
            'expire_date' => '2027-10-15',
            'purchase_price' => 800.00
        ]);

        $med4 = Medicine::create([
            'name' => 'Ventolin Inhaler 100mcg',
            'generic_name' => 'Salbutamol Albuterol',
            'category' => 'Bronchodilator (Asthma)',
            'formulation' => 'Inhaler',
            'dosage_rule' => 'As needed (PRN)',
            'stock' => 5, // Below Min Stock!
            'min_stock' => 10,
            'expire_date' => '2026-11-20', // Near expiry!
            'purchase_price' => 45000.00
        ]);

        $med5 = Medicine::create([
            'name' => 'Vitamin C 500mg',
            'generic_name' => 'Ascorbic Acid',
            'category' => 'Supplement',
            'formulation' => 'Tablet',
            'dosage_rule' => '1x1 daily',
            'stock' => 250,
            'min_stock' => 50,
            'expire_date' => '2029-01-01',
            'purchase_price' => 300.00
        ]);

        // 7. Seed Procurements
        Procurement::create([
            'medicine_id' => $med3->id,
            'supplier_name' => 'PT Kimia Farma Tbk',
            'quantity' => 100,
            'status' => 'Proposed',
            'order_date' => now()->toDateString()
        ]);

        Procurement::create([
            'medicine_id' => $med4->id,
            'supplier_name' => 'PT Indofarma Tbk',
            'quantity' => 20,
            'status' => 'Received',
            'order_date' => '2026-08-01',
            'receive_date' => '2026-08-03'
        ]);
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\MockController;

// 1. Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Patients (Pendaftaran & Data Pasien) Routes
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
Route::get('/patients-arsip/medis', [MockController::class, 'arsipMedis'])->name('mock.arsip_medis');

// 3. Electronic Medical Records (RME) Routes
Route::get('/rekam-medis/create', [MedicalRecordController::class, 'create'])->name('rme.create');
Route::post('/rekam-medis', [MedicalRecordController::class, 'store'])->name('rme.store');
Route::get('/rekam-medis/{id}/edit', [MedicalRecordController::class, 'edit'])->name('rme.edit');
Route::put('/rekam-medis/{id}', [MedicalRecordController::class, 'update'])->name('rme.update');
Route::post('/rekam-medis/{id}/lock', [MedicalRecordController::class, 'lock'])->name('rme.lock');

// 4. Data Master (Tenaga Kesehatan & Poli/Layanan) Routes
Route::resource('/nakes', DoctorController::class)->names([
    'index' => 'nakes.index',
    'store' => 'nakes.store',
    'update' => 'nakes.update',
    'destroy' => 'nakes.destroy',
]);
Route::post('/nakes/{id}/toggle-status', [DoctorController::class, 'toggleStatus'])->name('nakes.toggle_status');

Route::resource('/poli', PoliController::class)->names([
    'index' => 'poli.index',
    'store' => 'poli.store',
    'update' => 'poli.update',
    'destroy' => 'poli.destroy',
]);

// 5. Medicines (Inventaris & Pengadaan) Routes
Route::get('/obat', [MedicineController::class, 'index'])->name('medicines.index');
Route::get('/obat/pengadaan', [MedicineController::class, 'pengadaan'])->name('medicines.pengadaan');
Route::post('/obat/pengadaan', [MedicineController::class, 'storeProcurement'])->name('medicines.store_procurement');
Route::post('/obat/pengadaan/{id}/status', [MedicineController::class, 'updateProcurementStatus'])->name('medicines.update_procurement_status');

// 6. Mock Routes for complete child submenus (Reports, Campus Stock, Parameters)
Route::get('/obat/stok-kampus', [MockController::class, 'obatMock'])->defaults('type', 'stok-kampus')->name('mock.stok_kampus');
Route::get('/obat/permohonan-stok', [MockController::class, 'obatMock'])->defaults('type', 'permohonan-stok')->name('mock.permohonan_stok');

Route::get('/rekap/{type}', [MockController::class, 'rekap'])->name('mock.rekap');
Route::get('/pengaturan/{type}', [MockController::class, 'pengaturan'])->name('mock.pengaturan');

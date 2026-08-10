<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\MockController;

// 0. Auth & Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard')->with('success', 'Berhasil masuk ke akun Poliklinik Al-Azhar!');
})->name('login.perform');

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

// 5. Medicines (Inventaris, Gudang, & Pengadaan) Routes
Route::get('/obat', [MedicineController::class, 'index'])->name('medicines.index');
Route::post('/obat', [MedicineController::class, 'storeMedicine'])->name('medicines.store_medicine');
Route::put('/obat/{id}', [MedicineController::class, 'updateMedicine'])->name('medicines.update_medicine');
Route::delete('/obat/{id}', [MedicineController::class, 'destroyMedicine'])->name('medicines.destroy_medicine');

Route::get('/obat/pengadaan', [MedicineController::class, 'pengadaan'])->name('medicines.pengadaan');
Route::post('/obat/invoice', [MedicineController::class, 'storeInvoice'])->name('medicines.store_invoice');
Route::post('/obat/pengadaan', [MedicineController::class, 'storeProcurement'])->name('medicines.store_procurement');
Route::post('/obat/pengadaan/{id}/status', [MedicineController::class, 'updateProcurementStatus'])->name('medicines.update_procurement_status');

Route::get('/obat/stok-kampus', [MedicineController::class, 'stokKampus'])->name('mock.stok_kampus');

Route::get('/obat/permohonan-stok', [MedicineController::class, 'permohonanStok'])->name('mock.permohonan_stok');
Route::post('/obat/permohonan-stok', [MedicineController::class, 'storeStockRequest'])->name('medicines.store_stock_request');
Route::post('/obat/permohonan-stok/{id}/status', [MedicineController::class, 'updateRequestStatus'])->name('medicines.update_request_status');

// 6. Mock Rekap & Settings Routes
Route::get('/rekap/{type}', [MockController::class, 'rekap'])->name('mock.rekap');
Route::get('/pengaturan/{type}', [MockController::class, 'pengaturan'])->name('mock.pengaturan');

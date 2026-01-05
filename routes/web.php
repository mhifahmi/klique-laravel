<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Volt::route('/queue-public', 'queue-public')->name('queue.public');

// auth process
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register-staff', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register-staff', [AuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// route dashboard
Route::middleware(['auth'])->prefix('dashboard')->group(function () {

    // 1. Dashboard Utama
    // URL: domain.com/dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Halaman Operator Antrian (Livewire)
    // URL: domain.com/dashboard/antrian
    // Route::get('/queue', [DashboardController::class, 'index'])->name('dashboard-queue');
    Route::resource('queue', PatientController::class);

    // otomatis membuat route untuk index, create, store, edit, update, destroy.

    // 3. Manajemen Pasien
    // URL: domain.com/dashboard/patients
    // URL: domain.com/dashboard/patients/create
    // dst...
    Route::resource('patients', PatientController::class);

    // 4. Manajemen Dokter
    // URL: domain.com/dashboard/doctors
    Route::resource('doctors', DoctorController::class);

    // 5. Manajemen Ruangan
    // URL: domain.com/dashboard/rooms
    Route::resource('rooms', RoomController::class);
});

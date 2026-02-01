<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// public view for queue
Volt::route('/queue-public', 'queue-public')->name('queue.public');

/**
 * only can accessed while staff not login
 * only for login and register page
 * the register page can removed due system
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// to logout after login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// dashboard route only for staff to manage data
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    // main dashboard for see graph
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
     * dashboard for manage queues data
     * using livewire for syncronous data without load page
     */
    Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');

    /**
     * dashboard for manage patients, doctors, and rooms data
     * using basic laravel view and controller
     */
    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('rooms', RoomController::class);
});

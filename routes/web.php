<?php
// routes/web.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Chatbot Routes (bisa diakses tanpa login)
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

// Masyarakat Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $pengaduan = \App\Models\Pengaduan::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
        return view('dashboard', compact('pengaduan'));
    })->name('dashboard');

    Route::resource('pengaduan', PengaduanController::class);
});

// Petugas Routes
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan/{pengaduan}', [PetugasDashboardController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{pengaduan}', [PetugasDashboardController::class, 'update'])->name('pengaduan.update');
});
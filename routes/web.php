<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KulinerController;

Route::get('/', function () {
    return view('landingpage');
})->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin', 'status'])->prefix('dashboard/admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard.admin');

    // User Management
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('admin.users.toggle-ban');

    // Kuliner Routes - dengan prefix dashboard/admin
    Route::get('/kuliner/manage', [KulinerController::class, 'manage'])->name('admin.kuliner.manage');
    Route::get('/kuliner/create', [KulinerController::class, 'create'])->name('kuliner.create');
    Route::post('/kuliner/store', [KulinerController::class, 'store'])->name('kuliner.store');

    // Routes dengan parameter ID
    Route::get('/kuliner/{id}/show', [KulinerController::class, 'show'])->name('kuliner.show');
    Route::get('/kuliner/{id}/edit', [KulinerController::class, 'edit'])->name('kuliner.edit');
    Route::put('/kuliner/{id}/update', [KulinerController::class, 'update'])->name('kuliner.update');
    Route::delete('/kuliner/{id}/delete', [KulinerController::class, 'destroy'])->name('kuliner.destroy');
});

// User Routes
Route::get('/dashboard/user', function () {
    return view('dashboarduser');
})->name('dashboard.user')->middleware(['auth', 'role:user', 'status']);

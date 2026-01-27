<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\UserDashboardController;

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
    Route::get('/users/{user}/detail', [AdminController::class, 'getUserDetail'])->name('admin.users.detail');
    Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('admin.users.export');
    Route::post('/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('admin.users.toggle-ban');
    Route::get('/users/{user}/logs', [AdminController::class, 'logs'])->name('admin.users.logs');

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
Route::middleware(['auth', 'role:user', 'status'])->prefix('dashboard/user')->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard.user');

    // API-like routes for AJAX interactions
    Route::get('/kuliner/{id}', [UserDashboardController::class, 'show'])->name('user.kuliner.show');
    Route::post('/kuliner/{kuliner}/favorite', [UserDashboardController::class, 'toggleFavorite'])->name('user.kuliner.favorite');
    Route::post('/kuliner/{kuliner}/rate', [UserDashboardController::class, 'rate'])->name('user.kuliner.rate');
    Route::post('/kuliner/{kuliner}/review', [UserDashboardController::class, 'storeReview'])->name('user.kuliner.review');
    Route::post('/review/{review}/like', [UserDashboardController::class, 'toggleReviewLike'])->name('user.review.like');
});

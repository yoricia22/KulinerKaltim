<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', [KulinerController::class, 'landing'])->name('landing');
Route::get('/api/kuliner/{id}', [KulinerController::class, 'showGuest'])->name('kuliner.show.guest');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('dashboard.admin');
    
    // Kuliner Management
    Route::get('/admin/kuliner', [KulinerController::class, 'manage'])->name('admin.kuliner.manage');
    Route::get('/admin/kuliner/create', [KulinerController::class, 'create'])->name('kuliner.create');
    Route::post('/admin/kuliner', [KulinerController::class, 'store'])->name('kuliner.store');
    Route::get('/admin/kuliner/{id}/edit', [KulinerController::class, 'edit'])->name('kuliner.edit');
    Route::put('/admin/kuliner/{id}', [KulinerController::class, 'update'])->name('kuliner.update');
    Route::delete('/admin/kuliner/{id}/delete', [KulinerController::class, 'destroy'])->name('kuliner.destroy');
    Route::get('/dashboard/admin/kuliner/{id}/show', [KulinerController::class, 'show'])->name('kuliner.show');
    
    // User Management
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/admin/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('admin.users.toggle-ban');
    
    // Placeholder routes (coming soon features)
    Route::get('/admin/reviews', function () {
        return view('dashboardadmin');
    })->name('admin.reviews.index');
    
    Route::get('/admin/activity-logs', function () {
        return view('dashboardadmin');
    })->name('admin.activity-logs');
    
    Route::get('/admin/settings', function () {
        return view('dashboardadmin');
    })->name('admin.settings');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard/user', [UserDashboardController::class, 'index'])->name('dashboard.user');
    Route::get('/dashboard/user/favorites', [UserDashboardController::class, 'favorites'])->name('user.favorites');
    Route::get('/dashboard/user/kuliner/{id}', [UserDashboardController::class, 'show'])->name('user.kuliner.show');
    Route::post('/dashboard/user/kuliner/{kuliner}/favorite', [UserDashboardController::class, 'toggleFavorite'])->name('user.kuliner.favorite');
    Route::post('/dashboard/user/kuliner/{kuliner}/rate', [UserDashboardController::class, 'rate'])->name('user.kuliner.rate');
    Route::post('/dashboard/user/kuliner/{kuliner}/review', [UserDashboardController::class, 'storeReview'])->name('user.kuliner.review');
    Route::post('/dashboard/user/review/{review}/like', [UserDashboardController::class, 'toggleReviewLike'])->name('user.review.like');
});


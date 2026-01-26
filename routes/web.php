<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landingpage');
})->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard/admin', function () {
    return view('dashboardadmin');
})->name('dashboard.admin')->middleware(['auth', 'role:admin']);

Route::middleware(['auth', 'role:admin'])->prefix('dashboard/admin')->name('admin.')->group(function () {
    Route::get('/manage-users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle-ban', [App\Http\Controllers\Admin\AdminUserController::class, 'toggleBan'])->name('users.toggle-ban');
    Route::get('/users/{user}/logs', [App\Http\Controllers\Admin\AdminUserController::class, 'logs'])->name('users.logs');
});

Route::get('/dashboard/user', function () {
    return view('dashboarduser');
})->name('dashboard.user')->middleware(['auth', 'role:user']);

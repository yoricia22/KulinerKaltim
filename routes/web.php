<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
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

Route::get('/dashboard/user', function () {
    return view('dashboarduser');
})->name('dashboard.user')->middleware(['auth', 'role:user']);

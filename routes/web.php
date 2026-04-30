<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use Illuminate\Support\Facades\Route;

// Pagina principală (publică)
Route::get('/', function () {
    return view('home');
})->name('home');

// Rute autentificare (doar pentru needautentificați)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute jurnal (doar pentru autentificați)
Route::middleware('auth')->group(function () {
    Route::resource('entries', EntryController::class);
});
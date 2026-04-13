<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Nanti dashboard kita taruh di sini
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return "Ini halaman dashboard. Nanti kita ganti dengan komponen Livewire.";
    })->name('dashboard');
});
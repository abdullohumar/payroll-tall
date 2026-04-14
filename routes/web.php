<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard'); // Kita akan buat file blade sederhana untuk ini
    })->name('dashboard');

    // ROUTE BARU: Master Data
    Route::get('/departemen', \App\Livewire\Master\DepartemenIndex::class)->name('departemen.index');
    Route::get('/jabatan', \App\Livewire\Master\JabatanIndex::class)->name('jabatan.index'); // <-- Tambahkan ini
    // ROUTE BARU: Karyawan
    Route::get('/karyawan', \App\Livewire\Karyawan\KaryawanIndex::class)->name('karyawan.index');
    // Route Logout standar Laravel
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

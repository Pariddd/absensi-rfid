<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/export-excel', [DashboardController::class, 'exportExcel'])->name('export.excel');
Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('export.pdf');

Route::resource('mahasiswa', MahasiswaController::class)->except(['show']);

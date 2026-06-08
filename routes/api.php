<?php

use App\Http\Controllers\Api\AbsensiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('absensi')->group(function () {
    Route::post('/scan', [AbsensiController::class, 'scan']);
    Route::get('/', [AbsensiController::class, 'index']);
});

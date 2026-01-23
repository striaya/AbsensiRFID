<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;

Route::post('/absensi', [AbsensiController::class, 'store']);

Route::apiResource('/guru', GuruController::class);
Route::get('/guru', [GuruController::class, 'index']);
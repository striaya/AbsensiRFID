<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

Route::post('/absensi', [AbsensiController::class, 'store']);
Route::post('/absensi/keluar', [AbsensiController::class, 'keluar']);

Route::apiResource('/guru', GuruController::class);
Route::get('/guru', [GuruController::class, 'index']);

Route::apiResource('/device', DeviceController::class);
Route::get('/device', [DeviceController::class, 'index']);
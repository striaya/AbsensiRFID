<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

Route::post('/absensi', [AbsensiController::class, 'store']);
Route::post('/absensi/keluar', [AbsensiController::class, 'keluar']);

Route::apiResource('/device', DeviceController::class);
Route::get('/device', [DeviceController::class, 'index']);

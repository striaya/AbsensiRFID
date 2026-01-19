<?php

use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;

Route::post('/absensi', [AbsensiController::class, 'store']);

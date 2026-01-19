<?php

use App\Http\Controllers\Api\AbsensiController;
use Illuminate\Support\Facades\Route;

Route::post('/absensi', [AbsensiController::class, 'store']);

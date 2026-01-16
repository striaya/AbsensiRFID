<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AbsensiController;

Route::post('/absensi/tap', [AbsensiController::class, 'tap']);
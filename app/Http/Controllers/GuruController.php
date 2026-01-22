<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index() {
        return response()->json([
            'succes' => true,
            'data' => Guru::all()
        ]);
    }
}

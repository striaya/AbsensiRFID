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

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|unique:gurus',
            'email' => 'required|email|unique:gurus'
        ]);

        $guru = Guru::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil ditambahkan',
            'data' => $guru
        ], 201);
    }

    public function show($id) {
        $guru = Guru::find($id);

        if(!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $guru
        ]);
    } 

    public function update(Request $request, $id){
        $guru = Guru::find($id);

        if(!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:gurus,nip,' .$id,
            'email' => 'required|email|enique:gurus,email, ' .$id
        ]);

        $guru->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil diupdate',
            'data' => $guru
        ]);
    }

    public function destroy($id){
        $guru = Guru::find($id);

        if(!$guru) {
            return response()->json([
                'success' => false,
                'message' => "Guru tidak ditemukan"
            ], 404);
        }

        $guru->delete();

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil dihapus'
        ]);
    }
}

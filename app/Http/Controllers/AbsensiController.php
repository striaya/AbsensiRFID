<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function tap(Request $request)
    {
        $request->validate([
            'api_key' => 'required',
            'rfid_uid' => 'required',
        ]);

        $device = Device::where('api_key', $request->api_key)
        ->where('is_active', true)
        ->first();

        if(!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API Key or Device Inactive'
                ], 401);
        }

        $user = User::where('rfid_uid', $request->rfid_uid)->first();

        if(!$user) {
            return response()->json ([
                'status' => 'error',
                'message' => 'card not registered'
            ], 404);
        }

        $today = carbon::today();

        $absensi = Absensi::where('user_id', $user->id)
        ->whereDate('tanggal', $today)
        ->first();

        if(!$absensi) {
            Absensi::create([
                'user_id' => $user->id,
                'device_id' => $device->id,
                'tanggal' => $today,
                'jam_masuk' => carbon::now()->format('H:i:s'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Check-in Recorded',
                'nama' => $user->name,
            ]);

            if($absensi && !$absensi->jam_keluar == null) {
                $absensi->update([
                    'jam_keluar' => carbon::now()->format('H:i:s'),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Check-out Recorded',
                    'nama' => $user->name,
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'You have already checked in and out today',
                'nama' => $user->name
            ]);
        }
    }
}
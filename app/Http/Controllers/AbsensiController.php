<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'api_key' => 'required',
            'rfid_uid' => 'required',
        ]);

        $device = Device::where('api_key', $request->api_key)
            ->where('is_active', true)
            ->first();

        if (! $device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API Key or Device Inactive',
            ], 401);
        }

        $user = User::where('rfid_uid', $request->rfid_uid)->first();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'card not registered',
            ], 404);
        }

        $today = carbon::today();

        $absensi = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (! $absensi) {
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
        }

        if ($absensi && ! $absensi->jam_keluar == null) {
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
            'message' => 'Already Checked Out',
        ], 400);

        if (! $device->is_active) {
            return response()->json([
                'message' => 'Device is inactive',
            ], 403);
        }
        }
        public function keluar(Request $request){
            $request->validate([
                'api_key' => 'required',
                'rfid_uid' => 'required'
            ]);

            $device = Device::where('api_key', $request->api_key)->first();

            if(!$device) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device tidak ditemukan'
                ], 401);
            }

            if(!$device->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device nonaktif'
                ], 403);
            }

            $user = User::where('rfid_uid', $request->rfid_uid)->first();

            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemuka'
                ], 404);
            }

            $absensi = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', Carbon::today())
                ->whereNull('jam_keluar')
                ->first();

                if(!$absensi) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Absensi keluar tidak ditemukan atau sudah melakukan absensi keluar'
                    ], 400);
                }

                $absensi->update([
                    'jam_keluar' => Carbon::now()->format('H:i:s')
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Absensi keluar berhasil',
                    'data' => [
                        'nama' => $user->name,
                        'tanggal' => $absensi->tanggal,
                        'jam_keluar'=> $absensi->jam_keluar
                    ]
                ]);
            }
        }

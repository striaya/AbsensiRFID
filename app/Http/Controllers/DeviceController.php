<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Device::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string',
            'location' => 'nullable|string'
        ]);

        $device = Device::create([
            'device_name' => $request->device_name,
            'location' => $request->location,
            'api_key' => Str::random(40),
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device berhasil ditambahkan',
            'data' => $device
        ]);
    }

    public function update(Request $request, $id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'device_name' => 'required',
            'location' => 'nullable',
            'is_active' => 'boolean'
        ]);

        $device->device_name = $request->device_name;
        $device->location = $request->location;
        $device->is_active = $request->is_active ?? $device->is_active;
        $device->save();

        return response()->json([
            'success' => true,
            'message' => 'Device berhasil diupdate',
            'data' => $device
        ]);
    }

    public function destroy($id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device tidak ditemukan'
            ], 404);
        }

        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device berhasil dihapus'
        ]);
    }
}

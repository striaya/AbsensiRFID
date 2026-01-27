<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Absensi;

class Device extends Model
{
    Protected $fillable = [
        'device_name',
        'api_key',
        'location',
        'is_active'
        ];
        
        public function absensis()
        {
            return $this->hasMany(Absensi::class);
        }
}


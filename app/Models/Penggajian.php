<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table = 'penggajian';
    protected $guarded = []; // Izinkan semua kolom diisi massal

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
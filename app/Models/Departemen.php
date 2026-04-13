<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departemen extends Model
{
    // Eksplisit menentukan nama tabel agar tidak menggunakan bahasa Inggris
    protected $table = 'departemen';

    // Mengizinkan mass-assignment untuk kolom ini
    protected $fillable = ['kode', 'nama'];

    /**
     * Relasi One-to-Many: 1 Departemen memiliki banyak Jabatan
     */
    public function jabatan(): HasMany
    {
        return $this->hasMany(Jabatan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    
    protected $fillable = ['departemen_id', 'nama', 'gaji_pokok'];

    /**
     * Relasi Many-to-One: Banyak Jabatan dimiliki oleh 1 Departemen
     */
    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }
}
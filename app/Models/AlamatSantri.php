<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatSantri extends Model
{
    protected $table   = 'alamat_santris';

    protected $fillable = [
        'dusun',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
    ];

    /* 🔗 1 : 1 ke Santri */
    public function santri()
    {
        return $this->hasOne(Santri::class, 'alamat_id');
    }
}

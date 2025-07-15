<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlamatSantri extends Model
{
    protected $table   = 'alamat_santris';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dusun',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'santri_id'
    ];

    /* 🔗 1 : 1 ke Santri */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}

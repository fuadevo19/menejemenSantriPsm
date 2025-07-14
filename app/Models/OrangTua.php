<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $fillable = [
        'santri_id', 'tipe', 'nama', 'tahun_lahir', 'nik',
        'pendidikan', 'pekerjaan', 'penghasilan',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}


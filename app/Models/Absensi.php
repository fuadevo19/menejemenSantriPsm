<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'santri_id',
        'kelas_id',      // tambahkan ini
        'semester_id',
        'sakit',
        'izin',
        'alpha',
        'user_id',
    ];

    /* =======================
       RELATIONSHIPS
    ======================== */

    public function santri()
    {
        return $this->belongsTo(\App\Models\Santri::class);
    }

    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class);
    }

    public function semester()
    {
        return $this->belongsTo(\App\Models\Semester::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
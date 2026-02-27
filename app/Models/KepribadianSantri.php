<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class KepribadianSantri extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'santri_id',
        'kelas_id',
        'semester_id',
        'akhlaq',
        'kerajinan',
        'kedisiplinan',
        'kerapihan',
        'catatan',
        'user_id',
    ];

    /* ================= RELASI ================= */

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
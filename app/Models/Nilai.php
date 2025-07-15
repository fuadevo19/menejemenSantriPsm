<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nilai extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'santri_id',
        'mata_pelajaran_id',
        'kelas_id',
        'semester_id',
        'tahun_ajaran_id',
        'nilai',
        'jumlah_terbilang',
        'jumlah_terbilang_arab',
        'user_id',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Santri extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_santri',
        'no_induk',
        'NISN/NIS',
        'alamat',
        'angkatan',
        'kelas_id',
        'user_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

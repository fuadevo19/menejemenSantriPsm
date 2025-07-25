<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'label',
        'tahun_mulai',
        'tahun_selesai',
        'kepala_madrasah',
        'nip_kepala_madrasah',
        'pengasuh',
        'nip_pengasuh'
    ];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

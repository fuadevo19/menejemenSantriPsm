<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Santri extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_santri',
        'no_induk',
        'nisn',            // ← ganti dari “NISN/NIS”
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'anak_ke',
        'sekolah_asal',
        'diterima_sebagai',
        'tanggal_diterima',
        'angkatan',
        'kelas_id',
        'kelas_awal_id',
        'rombel',
        'user_id',
        'alamat_id',       // foreign key ke tabel alamat_santris (jika dipakai)
    ];

    /* ---------- Relasi dasar ---------- */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ---------- Relasi alamat (one‑to‑one) ---------- */
    public function alamat()
    {
        return $this->hasOne(AlamatSantri::class);
        
    }

    /* ---------- Relasi orang‑tua (jika pakai tabel orang_tuas) ---------- */
    public function orangTuas()
    {
        return $this->hasMany(OrangTua::class);
    }

    public function ayah()
    {
        return $this->hasOne(OrangTua::class)->where('tipe', 'ayah');
    }

    public function ibu()
    {
        return $this->hasOne(OrangTua::class)->where('tipe', 'ibu');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function getTanggalDiterimaFormattedAttribute()
{
    if (! $this->tanggal_diterima) {
        return null;
    }

    return Carbon::parse($this->tanggal_diterima)
        ->locale('id')
        ->translatedFormat('j F Y'); // contoh: 1 Juli 2025
}
}

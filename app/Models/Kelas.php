<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_kelas',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }
}

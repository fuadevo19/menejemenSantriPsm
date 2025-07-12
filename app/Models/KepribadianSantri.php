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
        'akhlaq',
        'kerajinan',
        'kedisiplinan',
        'kerapihan',
        'user_id',
        'semester_id'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function semester()
    {
        return $this->belongsTo(\App\Models\Semester::class);
    }
}

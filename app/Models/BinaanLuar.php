<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinaanLuar extends Model
{
    use HasFactory;

    protected $table = 'binaan_luar';

    protected $fillable = [
        'premis_id',
        'bil',
        'nama_binaan_luar',
        'jenis_binaan_luar',
        'luas_tapak',
        'kod_binaan_luar_myspata',
        'catatan',
    ];

    public function premis()
    {
        return $this->belongsTo(Premis::class);
    }

    public function aras()
    {
        return $this->hasMany(KodAras::class, 'binaan_luar_id');
    }
}
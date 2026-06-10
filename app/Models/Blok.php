<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    use HasFactory;

    protected $table = 'blok';

    protected $fillable = [
        'premis_id',
        'bil',
        'nama_blok',
        'fungsi_binaan',
        'luas_tapak',
        'kod_blok_myspata',
        'catatan',
    ];

    public function premis()
    {
        return $this->belongsTo(Premis::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KemasanRuang extends Model
{
    use HasFactory;

    protected $table = 'kemasan_ruangs';

    protected $fillable = [
        'ruang_id',
        'blok',
        'aras',
        'nama_aras',
        'kod_ruang',
        'kemasan_lantai',
        'luas_lantai',
        'kemasan_dinding',
        'luas_dinding',
        'kemasan_siling',
        'luas_siling',
    ];

    protected $casts = [
        'luas_lantai'   => 'decimal:2',
        'luas_dinding'  => 'decimal:2',
        'luas_siling'   => 'decimal:2',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * Relationship: belongs to KodRuang
     */
    public function ruang()
    {
        return $this->belongsTo(KodRuang::class, 'ruang_id');
    }
}

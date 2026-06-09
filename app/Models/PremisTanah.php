<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremisTanah extends Model
{
    protected $table = 'premis_tanah';

    protected $fillable = [
        'premis_id',
        'bil',
        'no_lot',
        'status_hakmilik',
        'keluasan_tanah',
        'no_hakmilik',
        'jenis_hakmilik',
        'tempoh_pajak',
        'kegunaan_tanah',
        'harga_perolehan',
        'harga_semasa',
    ];

    // Relationship balik ke premis
    public function premis()
    {
        return $this->belongsTo(Premis::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremisLukisan extends Model
{
    protected $table = 'premis_lukisan';

    protected $fillable = [
        'premis_id',
        'bil',
        'bidang',
        'tajuk_lukisan',
        'no_rujukan',
        'catatan',
    ];

    // Relationship balik ke premis
    public function premis()
    {
        return $this->belongsTo(Premis::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'sistem_id',
        'subsistem_id',
        'nama_premis',
        'kod_lokasi',
        'kod_blok',
        'nama_blok',
        'ada_blok',
        'kod_aras',
        'nama_aras',
        'ada_aras',
        'kod_ruang',
        'nama_ruang',
        'catatan_blok',
        'ada_ruang',
        'kod_binaan_luar',
        'nama_binaan_luar',
        'ada_binaan_luar',
        'nombor_dpa',
        'status',
        'koordinat_x',
        'koordinat_y',
        'kod_aras_binaan',
        'nama_aras_binaan',
        'kod_ruang_binaan',
        'nama_ruang_binaan',
        'catatan_binaan'
        // ... tambah field lain yang ada
    ];

    protected $casts = [
        'ada_blok' => 'boolean',
        'ada_aras' => 'boolean',
        'ada_ruang' => 'boolean',
        'ada_binaan_luar' => 'boolean',
        'status' => 'string',
    ];

    /**
     * Relationship: Component belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Component belongs to Sistem
     */
    public function sistem()
    {
        return $this->belongsTo(Sistem::class, 'sistem_id');
    }

    /**
     * Relationship: Component belongs to Subsistem
     */
    public function subsistem()
    {
        return $this->belongsTo(Subsistem::class, 'subsistem_id');
    }

    /**
     * Relationship: Component has many MainComponents
     */
    public function mainComponents()
    {
        return $this->hasMany(MainComponent::class, 'component_id');
    }

    /**
     * Scope: Get active components
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope: Get inactive components
     */
    public function scopeTidakAktif($query)
    {
        return $query->where('status', 'tidak_aktif');
    }
}
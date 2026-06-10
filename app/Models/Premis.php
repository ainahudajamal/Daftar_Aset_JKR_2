<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premis extends Model
{
    protected $table = 'premis';

    protected $fillable = [
        'nama_premis',
        'alamat_premis',
        'poskod',
        'koordinat_x',
        'koordinat_y',
        'kumpulan_agensi',
        'kementerian',
        'jabatan',
        'negara',
        'negeri',
        'daerah',
        'mukim_bandar',
        'kategori_premis',
        'sub_kategori',
        'jumlah_keluasan',
        'status_premis',
        'aset_warisan',
        'kos_siap_bina_asal',
        'kos_tambahan_ppun',
        'kos_keseluruhan',
        'sumber_pembiayaan',
        'kod_ptj',
        'nilai_semasa',
        'tarikh_siap_bina',
        'tarikh_penilaian',
        'no_dpa',
        'catatan',
        'bil_blok_bangunan',
        'bil_binaan_luar',
        'pengumpul_nama',
        'pengumpul_jawatan',
        'pengumpul_tarikh',
        'pengesah_nama',
        'pengesah_jawatan',
        'pengesah_tarikh',
    ];

    protected $casts = [
        'aset_warisan' => 'boolean',
        'tarikh_siap_bina' => 'date',
        'tarikh_penilaian' => 'date',
    ];

    // Relationship
    public function tanah()
    {
        return $this->hasMany(PremisTanah::class);
    }

    public function lukisan()
    {
        return $this->hasMany(PremisLukisan::class);
    }

    public function blok()
    {
        return $this->hasMany(Blok::class);
    }

    public function binaanLuar()
    {
        return $this->hasMany(BinaanLuar::class);
    }
}

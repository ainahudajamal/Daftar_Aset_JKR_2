<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Da5Record extends Model
{
    protected $table = 'da5_records';

    protected $fillable = [
        'nama_premis_id',
        'nama_premis',
        'no_dpa',
        'kod_blok',
        'nama_blok',
        'fungsi_binaan',
        'jenis_binaan',
        'gps_x',
        'gps_y',
        'kontraktor_utama',
        'bidang_kontraktor_utama',
        'kontraktor_list',
        'juru_perunding_utama',
        'bidang_juru_perunding_utama',
        'juru_perunding_list',
        'tahun_siap_bina',
        'tarikh_siap_bina',
        'fungsi_asal',
        'jenis_struktur',
        'no_siri_pendaftaran',
        'jangka_hayat',
        'kapasiti_penghuni',
        'kos_bina_asal',
        'nilai_semasa',
        'tarikh_penilaian',
        'sumber_pembiayaan',
        'kod_ptj',
        'penggunaan_tenaga',
        'penggunaan_air',
        'jenis_milikan',
        'aset_warisan',
        'bil_aras_atas',
        'bil_aras_bawah',
        'status_blok',
        'jumlah_luas_lantai',
        'luas_tapak',
        'gambar_hadapan',
        'gambar_belakang',
        'lukisan_list'
    ];

    protected $casts = [
        'kontraktor_list' => 'array',
        'juru_perunding_list' => 'array',
        'lukisan_list' => 'array',
        'aset_warisan' => 'boolean',
        'tarikh_siap_bina' => 'date',
        'tarikh_penilaian' => 'date',
    ];

    public function premis()
    {
        return $this->belongsTo(Premis::class, 'nama_premis_id');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('da5_records', function (Blueprint $table) {
            $table->id();
            
            // 1. Maklumat Premis & Blok / Binaan Luar
            $table->unsignedBigInteger('nama_premis_id')->nullable();
            $table->string('nama_premis')->nullable();
            $table->string('no_dpa')->nullable();
            $table->string('kod_blok')->nullable();
            $table->string('nama_blok')->nullable();
            $table->string('fungsi_binaan')->nullable();
            $table->string('jenis_binaan')->nullable();
            $table->string('gps_x')->nullable();
            $table->string('gps_y')->nullable();

            // 2.1 Kontraktor
            $table->string('kontraktor_utama')->nullable();
            $table->string('bidang_kontraktor_utama')->nullable();
            $table->json('kontraktor_list')->nullable();

            // 2.2 Juru Perunding
            $table->string('juru_perunding_utama')->nullable();
            $table->string('bidang_juru_perunding_utama')->nullable();
            $table->json('juru_perunding_list')->nullable();

            // 3. Maklumat Kewangan, Operasi & Fizikal
            $table->string('tahun_siap_bina')->nullable();
            $table->date('tarikh_siap_bina')->nullable();
            $table->string('fungsi_asal')->nullable();
            $table->string('jenis_struktur')->nullable();
            $table->string('no_siri_pendaftaran')->nullable();
            $table->integer('jangka_hayat')->nullable();
            $table->integer('kapasiti_penghuni')->nullable();
            $table->decimal('kos_bina_asal', 15, 2)->nullable();
            $table->decimal('nilai_semasa', 15, 2)->nullable();
            $table->date('tarikh_penilaian')->nullable();
            $table->string('sumber_pembiayaan')->nullable();
            $table->string('kod_ptj')->nullable();
            $table->decimal('penggunaan_tenaga', 15, 2)->nullable();
            $table->decimal('penggunaan_air', 15, 2)->nullable();
            $table->string('jenis_milikan')->nullable();

            // 4. Maklumat Helaian 2
            $table->boolean('aset_warisan')->default(false);
            $table->integer('bil_aras_atas')->nullable();
            $table->integer('bil_aras_bawah')->nullable();
            $table->string('status_blok')->nullable();
            $table->decimal('jumlah_luas_lantai', 15, 2)->nullable();
            $table->decimal('luas_tapak', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('da5_records');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premis', function (Blueprint $table) {
            $table->id();

            // Maklumat Asas
            $table->string('nama_premis');
            $table->text('alamat_premis')->nullable();
            $table->string('poskod', 10)->nullable();
            $table->decimal('koordinat_x', 10, 6)->nullable();
            $table->decimal('koordinat_y', 10, 6)->nullable();

            // Maklumat Agensi
            $table->string('kumpulan_agensi')->nullable();
            $table->string('kementerian')->nullable();
            $table->string('jabatan')->nullable();

            // Lokasi
            $table->string('negara')->nullable();
            $table->string('negeri')->nullable();
            $table->string('daerah')->nullable();
            $table->string('mukim_bandar')->nullable();

            // Kategori
            $table->string('kategori_premis')->nullable();
            $table->string('sub_kategori')->nullable();
            $table->decimal('jumlah_keluasan', 10, 2)->nullable();
            $table->string('status_premis')->default('Aktif');
            $table->boolean('aset_warisan')->default(false);

            // Kos
            $table->decimal('kos_siap_bina_asal', 15, 2)->nullable();
            $table->decimal('kos_tambahan_ppun', 15, 2)->nullable();
            $table->decimal('kos_keseluruhan', 15, 2)->nullable();
            $table->string('sumber_pembiayaan')->nullable();
            $table->string('kod_ptj')->nullable();
            $table->decimal('nilai_semasa', 15, 2)->nullable();

            // Tarikh
            $table->date('tarikh_siap_bina')->nullable();
            $table->date('tarikh_penilaian')->nullable();

            // No DPA
            $table->string('no_dpa')->unique()->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premis');
    }
};
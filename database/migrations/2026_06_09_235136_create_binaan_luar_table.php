<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('binaan_luar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('premis_id')->constrained('premis')->onDelete('cascade');
            $table->integer('bil')->nullable();
            $table->string('nama_binaan_luar')->nullable();
            $table->string('jenis_binaan_luar')->nullable();
            $table->decimal('luas_tapak', 10, 2)->nullable();
            $table->string('kod_binaan_luar_myspata')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('binaan_luar');
    }
};
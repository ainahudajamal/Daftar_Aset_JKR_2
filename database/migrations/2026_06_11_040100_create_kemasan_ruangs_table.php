<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kemasan_ruangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruang_id')->constrained('kod_ruangs')->onDelete('cascade');

            // Auto-filled from Ruang's Aras (stored as strings for historical integrity)
            $table->string('blok')->nullable();
            $table->string('aras')->nullable();
            $table->string('nama_aras')->nullable();
            $table->string('kod_ruang')->nullable();

            // Kemasan Lantai
            $table->string('kemasan_lantai')->nullable();
            $table->decimal('luas_lantai', 10, 2)->nullable();

            // Kemasan Dinding
            $table->string('kemasan_dinding')->nullable();
            $table->decimal('luas_dinding', 10, 2)->nullable();

            // Kemasan Siling
            $table->string('kemasan_siling')->nullable();
            $table->decimal('luas_siling', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kemasan_ruangs');
    }
};

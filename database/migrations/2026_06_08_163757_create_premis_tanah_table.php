<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premis_tanah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('premis_id')->constrained('premis')->onDelete('cascade');

            $table->integer('bil')->nullable();
            $table->string('no_lot')->nullable();
            $table->string('status_hakmilik')->nullable();
            $table->decimal('keluasan_tanah', 10, 2)->nullable();
            $table->string('no_hakmilik')->nullable();
            $table->string('jenis_hakmilik')->nullable();
            $table->integer('tempoh_pajak')->nullable();
            $table->string('kegunaan_tanah')->nullable();
            $table->decimal('harga_perolehan', 15, 2)->nullable();
            $table->decimal('harga_semasa', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premis_tanah');
    }
};
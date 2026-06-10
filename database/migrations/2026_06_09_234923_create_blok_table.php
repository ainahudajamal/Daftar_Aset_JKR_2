<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::create('blok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('premis_id')->constrained('premis')->onDelete('cascade');
            $table->integer('bil')->nullable();
            $table->string('nama_blok')->nullable();
            $table->string('fungsi_binaan')->nullable();
            $table->decimal('luas_tapak', 10, 2)->nullable();
            $table->string('kod_blok_myspata')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blok');
    }
};

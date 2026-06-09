<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premis_lukisan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('premis_id')->constrained('premis')->onDelete('cascade');

            $table->integer('bil')->nullable();
            $table->string('bidang')->nullable();
            $table->string('tajuk_lukisan')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premis_lukisan');
    }
};
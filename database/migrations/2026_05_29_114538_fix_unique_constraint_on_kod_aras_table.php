<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kod_aras', function (Blueprint $table) {
            // Buang unique constraint lama
            $table->dropUnique('kod_aras_kod_unique');
            
            // Tambah unique constraint baru (kod + blok_id)
            $table->unique(['blok_id', 'kod']);
        });
    }

    public function down(): void
    {
        Schema::table('kod_aras', function (Blueprint $table) {
            $table->dropUnique(['blok_id', 'kod']);
            $table->unique('kod');
        });
    }
};
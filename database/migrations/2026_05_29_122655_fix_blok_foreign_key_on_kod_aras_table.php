<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kod_aras', function (Blueprint $table) {
            // Buang foreign key lama yang point ke bloks
            $table->dropForeign(['blok_id']);
            
            // Tambah foreign key baru yang point ke kod_bloks
            $table->foreign('blok_id')
                  ->references('id')
                  ->on('kod_bloks')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kod_aras', function (Blueprint $table) {
            $table->dropForeign(['blok_id']);
            $table->foreign('blok_id')
                  ->references('id')
                  ->on('bloks')
                  ->nullOnDelete();
        });
    }
};
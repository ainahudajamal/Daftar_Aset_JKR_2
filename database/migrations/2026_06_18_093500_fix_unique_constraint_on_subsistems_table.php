<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subsistems', function (Blueprint $table) {
            // Buang unique constraint lama
            $table->dropUnique('subsistems_kod_unique');
            
            // Tambah unique constraint baru (sistem_id + kod)
            $table->unique(['sistem_id', 'kod']);
        });
    }

    public function down(): void
    {
        Schema::table('subsistems', function (Blueprint $table) {
            $table->dropUnique(['sistem_id', 'kod']);
            $table->unique('kod');
        });
    }
};

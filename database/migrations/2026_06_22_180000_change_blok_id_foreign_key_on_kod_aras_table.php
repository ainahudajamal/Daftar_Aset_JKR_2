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
        Schema::table('kod_aras', function (Blueprint $table) {
            // Drop foreign key referencing kod_bloks
            $table->dropForeign(['blok_id']);
            
            // Define new foreign key referencing the blok table (singular)
            $table->foreign('blok_id')
                  ->references('id')
                  ->on('blok')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kod_aras', function (Blueprint $table) {
            // Drop foreign key referencing blok
            $table->dropForeign(['blok_id']);
            
            // Define old foreign key referencing kod_bloks
            $table->foreign('blok_id')
                  ->references('id')
                  ->on('kod_bloks')
                  ->nullOnDelete();
        });
    }
};

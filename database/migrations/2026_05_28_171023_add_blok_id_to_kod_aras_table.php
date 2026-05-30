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
            $table->foreignId('blok_id')->nullable()->after('id')->constrained('bloks')->nullOnDelete();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kod_aras', function (Blueprint $table) {
            $table->dropForeign(['blok_id']);
            $table->dropColumn('blok_id');
        });
    }
};

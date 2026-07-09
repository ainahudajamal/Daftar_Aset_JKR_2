<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kod_ruangs', function (Blueprint $table) {
            $table->unsignedBigInteger('binaan_luar_id')->nullable()->after('aras_id');
            $table->foreign('binaan_luar_id')
                  ->references('id')
                  ->on('binaan_luar')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('kod_ruangs', function (Blueprint $table) {
            $table->dropForeign(['binaan_luar_id']);
            $table->dropColumn('binaan_luar_id');
        });
    }
};
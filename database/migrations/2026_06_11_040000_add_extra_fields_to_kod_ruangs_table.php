<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kod_ruangs', function (Blueprint $table) {
            $table->string('kod_sub_ruang')->nullable()->after('kod');
            $table->decimal('luas', 10, 2)->nullable()->after('nama');
            $table->decimal('tinggi', 10, 2)->nullable()->after('luas');
            $table->string('fungsi_ruang')->nullable()->after('tinggi');
            $table->string('ada_kemasan')->default('tiada')->after('fungsi_ruang'); // 'ada' or 'tiada'
        });
    }

    public function down(): void
    {
        Schema::table('kod_ruangs', function (Blueprint $table) {
            $table->dropColumn(['kod_sub_ruang', 'luas', 'tinggi', 'fungsi_ruang', 'ada_kemasan']);
        });
    }
};

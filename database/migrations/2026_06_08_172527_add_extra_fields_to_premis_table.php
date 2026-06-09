<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('premis', function (Blueprint $table) {
            $table->integer('bil_blok_bangunan')->default(0)->after('catatan');
            $table->integer('bil_binaan_luar')->default(0)->after('bil_blok_bangunan');
            $table->string('pengumpul_nama')->nullable()->after('bil_binaan_luar');
            $table->string('pengumpul_jawatan')->nullable()->after('pengumpul_nama');
            $table->date('pengumpul_tarikh')->nullable()->after('pengumpul_jawatan');
            $table->string('pengesah_nama')->nullable()->after('pengumpul_tarikh');
            $table->string('pengesah_jawatan')->nullable()->after('pengesah_nama');
            $table->date('pengesah_tarikh')->nullable()->after('pengesah_jawatan');
        });
    }

    public function down(): void
    {
        Schema::table('premis', function (Blueprint $table) {
            $table->dropColumn([
                'bil_blok_bangunan', 'bil_binaan_luar',
                'pengumpul_nama', 'pengumpul_jawatan', 'pengumpul_tarikh',
                'pengesah_nama', 'pengesah_jawatan', 'pengesah_tarikh',
            ]);
        });
    }
};
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
        Schema::table('da5_records', function (Blueprint $table) {
            $table->string('gambar_hadapan')->nullable()->after('luas_tapak');
            $table->string('gambar_belakang')->nullable()->after('gambar_hadapan');
            $table->json('lukisan_list')->nullable()->after('gambar_belakang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('da5_records', function (Blueprint $table) {
            $table->dropColumn(['gambar_hadapan', 'gambar_belakang', 'lukisan_list']);
        });
    }
};

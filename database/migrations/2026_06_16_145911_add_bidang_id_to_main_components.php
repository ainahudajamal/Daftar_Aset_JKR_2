<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('main_components', function (Blueprint $table) {
            // Add new bidang_id FK (nullable — old records may not have it yet)
            $table->unsignedBigInteger('bidang_id')->nullable()->after('subsistem');
            $table->foreign('bidang_id')->references('id')->on('bidangs')->nullOnDelete();
        });

        // ── Migrate existing boolean flag data ────────────────────────────────
        // Map old boolean flags to the bidang 'kod' column in bidangs table.
        // Only migrates if matching bidang records already exist.
        $map = [
            'elv_ict'       => 'T',
            'elektrikal'    => 'E',
            'mekanikal'     => 'M',
            'awam_arkitek'  => 'A',
            'bio_perubatan' => 'B',
        ];

        foreach ($map as $column => $kod) {
            $bidang = DB::table('bidangs')->where('kod', $kod)->first();
            if ($bidang) {
                DB::table('main_components')
                    ->where($column, 1)
                    ->whereNull('bidang_id')
                    ->update(['bidang_id' => $bidang->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_components', function (Blueprint $table) {
            $table->dropForeign(['bidang_id']);
            $table->dropColumn('bidang_id');
        });
    }
};

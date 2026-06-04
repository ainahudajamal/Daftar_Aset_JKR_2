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
        Schema::table('kod_ruangs', function (Blueprint $table) {
            $table->foreignId('aras_id')->nullable()->after('id')->constrained('kod_aras')->nullOnDelete();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kod_ruangs', function (Blueprint $table) {
            $table->dropForeign(['aras_id']);
            $table->dropColumn('aras_id');
            //
        });
    }
};

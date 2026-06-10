<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('premis', function (Blueprint $table) {
            $table->string('bil_binaan_luar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('premis', function (Blueprint $table) {
            $table->integer('bil_binaan_luar')->nullable(false)->change();
        });
    }
};
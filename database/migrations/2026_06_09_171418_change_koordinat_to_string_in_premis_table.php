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
        Schema::table('premis', function (Blueprint $table) {
            $table->string('koordinat_x')->nullable()->change();
            $table->string('koordinat_y')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('premis', function (Blueprint $table) {
            $table->decimal('koordinat_x', 10, 6)->nullable()->change();
            $table->decimal('koordinat_y', 10, 6)->nullable()->change();
        });
    }
};

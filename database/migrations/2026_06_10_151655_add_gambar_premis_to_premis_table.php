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
        $table->string('gambar_premis')->nullable()->after('catatan');
    });
}

public function down(): void
{
    Schema::table('premis', function (Blueprint $table) {
        $table->dropColumn('gambar_premis');
    });
}
};

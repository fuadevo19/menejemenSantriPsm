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
        // Tambah semester_id ke tabel absensis
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->constrained()->cascadeOnDelete();
        });

        // Tambah semester_id ke tabel kepribadian_santris
        Schema::table('kepribadian_santris', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropConstrainedForeignId('semester_id');
        });

        Schema::table('kepribadian_santris', function (Blueprint $table) {
            $table->dropConstrainedForeignId('semester_id');
        });
    }
};

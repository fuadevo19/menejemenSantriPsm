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
       Schema::create('orang_tuas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->cascadeOnDelete();
            $table->enum('tipe', ['ayah', 'ibu']);
            $table->string('nama')->nullable();
            $table->year('tahun_lahir')->nullable();
            $table->string('nik', 20)->nullable()->unique();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->unsignedBigInteger('penghasilan')->nullable();
            $table->timestamps();

            // 1 santri hanya boleh punya 1 ayah & 1 ibu
            $table->unique(['santri_id', 'tipe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tuas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kepribadian_santris', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();

            $table->integer('akhlaq')->nullable();
            $table->integer('kerajinan')->nullable();
            $table->integer('kedisiplinan')->nullable();
            $table->integer('kerapihan')->nullable();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // ✅ anti duplicate (versi baru)
            $table->unique(
                ['santri_id', 'semester_id', 'kelas_id'],
                'unique_kepribadian_santri'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kepribadian_santris');
    }
};
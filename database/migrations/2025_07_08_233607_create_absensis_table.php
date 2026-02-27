<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();

            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alpha')->default(0);

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // ✅ anti duplicate (versi baru)
            $table->unique(
                ['santri_id', 'semester_id', 'kelas_id'],
                'unique_absensi_santri'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
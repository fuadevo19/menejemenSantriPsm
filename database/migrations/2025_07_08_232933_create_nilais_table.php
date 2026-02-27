<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained()->onDelete('cascade');
            $table->float('nilai'); // bisa juga integer kalau tidak pakai desimal
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            //tambahkan soft delet dan hapus migras add_deleted_at_to_kepribadian_santris_table
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};

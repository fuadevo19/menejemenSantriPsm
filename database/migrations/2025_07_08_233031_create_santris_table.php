<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     public function up(): void
    {
        /* ---------- Tabel santris (ditambah kolom identitas) ---------- */
        Schema::create('santris', function (Blueprint $table) {
            $table->id();

            /* kolom lama */
            $table->string('nama_santri');
            $table->string('no_induk')->unique();
            $table->string('nisn')->nullable()->unique();     // was “NISN/NIS”
            $table->string('nik')->nullable()->unique();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->tinyInteger('anak_ke')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->string('diterima_sebagai')->nullable();
            $table->date('tanggal_diterima')->nullable();

            $table->string('angkatan');
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            /* relasi alamat jika dipisah */
            $table->foreignId('alamat_id')->nullable()->constrained('alamat_santris')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });

        

    }

    public function down(): void
    {
        Schema::dropIfExists('santris');
        Schema::dropIfExists('alamat_santris');
        Schema::dropIfExists('orang_tuas');
    }
};

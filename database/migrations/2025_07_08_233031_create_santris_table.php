<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('santris', function (Blueprint $table) {
        $table->id();
        $table->string('nama_santri');
        $table->string('no_induk')->unique();
        $table->string('NISN/NIS')->unique();
        $table->text('alamat')->nullable();
        $table->string('angkatan');
        $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ✅ siapa yang input
        $table->timestamps();
        $table->softDeletes();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};

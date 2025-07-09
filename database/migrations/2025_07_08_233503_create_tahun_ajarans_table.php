<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
        {
            Schema::create('tahun_ajarans', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('tahun_mulai');
            $table->integer('tahun_selesai');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('tahun_ajarans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

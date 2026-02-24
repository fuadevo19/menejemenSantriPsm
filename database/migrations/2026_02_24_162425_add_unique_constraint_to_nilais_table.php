<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->unique([
                'santri_id',
                'mata_pelajaran_id',
                'semester_id',
                'tahun_ajaran_id'
            ], 'unique_nilai_combination');
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropUnique('unique_nilai_combination');
        });
    }
};

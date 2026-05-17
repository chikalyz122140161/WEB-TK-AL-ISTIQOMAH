<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('student_enrollment', function (Blueprint $table) {
            $table->enum('aksi', ['ganti_semester', 'ganti_kelas', 'tinggal_kelas'])
                  ->nullable()
                  ->after('status');
            $table->uuid('class_term_tujuan_id')
                  ->nullable()
                  ->after('aksi');

            $table->foreign('class_term_tujuan_id')
                  ->references('id')
                  ->on('class_term')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('student_enrollment', function (Blueprint $table) {
            $table->dropForeign(['class_term_tujuan_id']);
            $table->dropColumn(['aksi', 'class_term_tujuan_id']);
        });
    }
};

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
        Schema::create('semester_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('tahun_ajaran'); // e.g., "2025/2026"
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('kelas'); // e.g., "TK A", "TK B"
            
            // Nilai Agama & Moral
            $table->enum('agama_moral', ['BB', 'MB', 'BSH', 'BSB'])->default('MB');
            $table->text('agama_moral_deskripsi')->nullable();
            
            // Nilai Motorik
            $table->enum('fisik_motorik', ['BB', 'MB', 'BSH', 'BSB'])->default('MB');
            $table->text('fisik_motorik_deskripsi')->nullable();
            
            // Nilai Kognitif
            $table->enum('kognitif', ['BB', 'MB', 'BSH', 'BSB'])->default('MB');
            $table->text('kognitif_deskripsi')->nullable();
            
            // Nilai Bahasa
            $table->enum('bahasa', ['BB', 'MB', 'BSH', 'BSB'])->default('MB');
            $table->text('bahasa_deskripsi')->nullable();
            
            // Nilai Sosial Emosional
            $table->enum('sosial_emosional', ['BB', 'MB', 'BSH', 'BSB'])->default('MB');
            $table->text('sosial_emosional_deskripsi')->nullable();
            
            // Nilai Seni
            $table->enum('seni', ['BB', 'MB', 'BSH', 'BSB'])->default('MB');
            $table->text('seni_deskripsi')->nullable();
            
            // Kehadiran
            $table->integer('hadir')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('sakit')->default(0);
            $table->integer('alpa')->default(0);
            
            // Catatan dan Rekomendasi
            $table->text('catatan_guru')->nullable();
            $table->text('rekomendasi')->nullable();
            
            $table->date('tanggal_terbit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester_reports');
    }
};

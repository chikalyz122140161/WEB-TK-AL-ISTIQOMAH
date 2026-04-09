<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('nisn')->nullable()->after('name');
            $table->string('nomor_induk')->nullable()->after('nisn');
            $table->string('tempat_lahir')->nullable()->after('nomor_induk');
            $table->string('nik')->nullable()->after('birth_date');
            $table->string('kelas')->nullable()->after('nik');
            $table->string('nama_ayah')->nullable()->after('address');
            $table->string('pekerjaan_ayah')->nullable()->after('nama_ayah');
            $table->string('nama_ibu')->nullable()->after('pekerjaan_ayah');
            $table->string('pekerjaan_ibu')->nullable()->after('nama_ibu');
            $table->string('telepon')->nullable()->after('pekerjaan_ibu');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'nisn', 'nomor_induk', 'tempat_lahir', 'nik', 'kelas',
                'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu', 'telepon',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('nama_panggilan')->nullable()->after('nama_lengkap');
            $table->string('agama')->nullable()->after('jenis_kelamin');
            $table->integer('anak_ke')->nullable()->after('alamat_siswa');
            $table->integer('jumlah_saudara')->nullable()->after('anak_ke');
            $table->string('suku_bangsa')->nullable()->after('jumlah_saudara');
            $table->string('riwayat_penyakit')->nullable()->after('suku_bangsa');
            $table->decimal('berat_badan', 5, 2)->nullable()->after('riwayat_penyakit');
            $table->decimal('tinggi_badan', 5, 2)->nullable()->after('berat_badan');

            $table->string('tempat_lahir_ayah')->nullable()->after('pendidikan_ayah');
            $table->date('tanggal_lahir_ayah')->nullable()->after('tempat_lahir_ayah');
            $table->string('no_telp_ayah')->nullable()->after('tanggal_lahir_ayah');

            $table->string('tempat_lahir_ibu')->nullable()->after('pendidikan_ibu');
            $table->date('tanggal_lahir_ibu')->nullable()->after('tempat_lahir_ibu');
            $table->string('no_telp_ibu')->nullable()->after('tanggal_lahir_ibu');

            $table->string('nama_wali')->nullable()->after('no_telp_ibu');
            $table->string('pekerjaan_wali')->nullable()->after('nama_wali');
            $table->string('tempat_lahir_wali')->nullable()->after('pendidikan_wali');
            $table->date('tanggal_lahir_wali')->nullable()->after('tempat_lahir_wali');
            $table->string('no_telp_wali')->nullable()->after('tanggal_lahir_wali');

            $table->string('password_ortu')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'nama_panggilan', 'agama', 'anak_ke', 'jumlah_saudara', 'suku_bangsa',
                'riwayat_penyakit', 'berat_badan', 'tinggi_badan',
                'tempat_lahir_ayah', 'tanggal_lahir_ayah', 'no_telp_ayah',
                'tempat_lahir_ibu', 'tanggal_lahir_ibu', 'no_telp_ibu',
                'nama_wali', 'pekerjaan_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'no_telp_wali',
                'password_ortu',
            ]);
        });
    }
};

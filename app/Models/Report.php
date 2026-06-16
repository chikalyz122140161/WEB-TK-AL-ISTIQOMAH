<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_enrollment_id'];

    // Function ini menghubungkan data rapot atau presensi dengan enrollment siswa.
    // Enrollment menunjukkan siswa berada di kelas dan semester tertentu.
    public function studentEnrollment()
    {
        return $this->belongsTo(StudentEnrollment::class, 'student_enrollment_id');
    }

    // Function ini menjelaskan daftar mata pelajaran yang terhubung dengan data ini.
    // Relasi ini dipakai saat mengatur aktivitas belajar atau mengisi rapot.
    public function subjects()
    {
        return $this->hasMany(ReportSubject::class, 'report_id');
    }

    // Function ini menjelaskan daftar ekstrakurikuler yang terhubung dengan data ini.
    // Relasi ini dipakai untuk pengaturan ekskul dan penilaian rapot.
    public function extracurriculars()
    {
        return $this->hasMany(ReportExtracurricular::class, 'report_id');
    }

    // Function ini menjelaskan daftar konseling atau BK yang terhubung dengan data ini.
    // Relasi ini dipakai untuk penilaian perkembangan siswa.
    public function counselings()
    {
        return $this->hasMany(ReportCounseling::class, 'report_id');
    }
}

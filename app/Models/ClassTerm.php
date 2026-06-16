<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTerm extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_id', 'academic_term_id', 'isPass'];

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return ['isPass' => 'boolean'];
    }

    // Function ini menghubungkan class term dengan data kelas.
    // Dengan relasi ini sistem bisa mengetahui nama kelas seperti A, B1, atau B2.
    public function class()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    // Function ini menghubungkan class term dengan tahun ajaran dan semester.
    // Relasi ini membantu membedakan data antar periode akademik.
    public function academicTerm()
    {
        return $this->belongsTo(AcademicTerm::class, 'academic_term_id');
    }

    // Function ini menjelaskan jadwal pembelajaran yang dimiliki oleh class term.
    // Jadwal ini biasanya berupa kegiatan rutin berdasarkan hari dan jam.
    public function classSchedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_term_id');
    }

    // Function ini menjelaskan jadwal kegiatan yang dimiliki oleh class term.
    // Jadwal ini biasanya berupa kegiatan sekolah berdasarkan tanggal tertentu.
    public function activitySchedules()
    {
        return $this->hasMany(ActivitySchedule::class, 'class_term_id');
    }

    // Function ini menjelaskan riwayat kelas yang pernah atau sedang diikuti siswa.
    // Relasi ini penting untuk mengetahui siswa berada di kelas dan tahun ajaran mana.
    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'class_term_id');
    }

    // Function ini menjelaskan daftar mata pelajaran yang terhubung dengan data ini.
    // Relasi ini dipakai saat mengatur aktivitas belajar atau mengisi rapot.
    public function subjects()
    {
        return $this->hasMany(ClassTermSubject::class, 'class_term_id');
    }

    // Function ini menjelaskan daftar ekstrakurikuler yang terhubung dengan data ini.
    // Relasi ini dipakai untuk pengaturan ekskul dan penilaian rapot.
    public function extracurriculars()
    {
        return $this->hasMany(ClassTermExtracurricular::class, 'class_term_id');
    }

    // Function ini menjelaskan daftar konseling atau BK yang terhubung dengan data ini.
    // Relasi ini dipakai untuk penilaian perkembangan siswa.
    public function counselings()
    {
        return $this->hasMany(ClassTermCounseling::class, 'class_term_id');
    }

    // Function ini menjelaskan daftar jadwal konseling pribadi yang terkait dengan data ini.
    // Jadwal ini bisa dibuat oleh guru atau diajukan oleh orang tua.
    public function privateCounselingSchedules()
    {
        return $this->hasMany(PrivateCounselingSchedule::class, 'class_term_id');
    }
}

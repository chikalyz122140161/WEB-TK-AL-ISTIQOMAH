<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentEnrollment extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'student_enrollment';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_id', 'class_term_id', 'status', 'aksi', 'class_term_tujuan_id'];

    // Function ini menjelaskan hubungan data ini dengan data siswa.
    // Relasi ini dipakai saat sistem perlu mengetahui siswa yang terkait dengan data tersebut.
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Function ini menjelaskan hubungan data ini dengan satu class term.
    // Dari relasi ini sistem bisa mengetahui kelas dan semester yang sedang dipakai.
    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    // Function ini menjelaskan class term tujuan saat siswa naik, pindah, atau tinggal kelas.
    // Relasi ini dipakai untuk menyimpan riwayat perpindahan siswa.
    public function classTermTujuan()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_tujuan_id');
    }

    // Function ini menjelaskan daftar presensi yang dimiliki enrollment siswa.
    // Relasi ini dipakai untuk menghitung hadir, izin, sakit, dan alpa.
    public function presences()
    {
        return $this->hasMany(Presence::class, 'student_class_id');
    }

    // Function ini menghubungkan data ini dengan rapot siswa.
    // Relasi ini dipakai untuk mengambil atau menyimpan hasil rapot.
    public function report()
    {
        return $this->hasOne(Report::class, 'student_enrollment_id');
    }
}

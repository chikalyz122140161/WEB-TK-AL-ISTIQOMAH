<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateCounselingSchedule extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'private_counseling_schedule';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'class_term_id',
        'status',
        'date',
        'start_hour',
        'end_hour',
        'topic',
        'source',
    ];

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    // Function ini menjelaskan hubungan data ini dengan data siswa.
    // Relasi ini dipakai saat sistem perlu mengetahui siswa yang terkait dengan data tersebut.
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Function ini menghubungkan jadwal konseling dengan data siswa anak.
    // Relasi ini dipakai ketika jadwal konseling perlu menampilkan nama siswa, bukan hanya akun orang tua.
    public function childStudent()
    {
        return $this->hasOne(Student::class, 'user_id', 'student_id');
    }

    // Function ini menghubungkan data ini dengan user guru.
    // Dengan relasi ini sistem bisa menampilkan siapa guru yang bertanggung jawab.
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Function ini menjelaskan hubungan data ini dengan satu class term.
    // Dari relasi ini sistem bisa mengetahui kelas dan semester yang sedang dipakai.
    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }
}

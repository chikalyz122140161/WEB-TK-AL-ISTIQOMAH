<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presence extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'presence';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_class_id', 'date', 'attendance', 'description'];

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    // Function ini menghubungkan data rapot atau presensi dengan enrollment siswa.
    // Enrollment menunjukkan siswa berada di kelas dan semester tertentu.
    public function studentEnrollment()
    {
        return $this->belongsTo(StudentEnrollment::class, 'student_class_id');
    }
}

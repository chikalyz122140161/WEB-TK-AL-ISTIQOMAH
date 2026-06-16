<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'student';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'name', 'gender', 'nis', 'nisn', 'pob', 'dob', 'nik',
        'address', 'phone', 'religion', 'birth_order', 'siblings_count',
        'ethnicity', 'illness_history', 'weight', 'height', 'nickname',
    ];

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return [
            'dob'            => 'date',
            'birth_order'    => 'integer',
            'siblings_count' => 'integer',
            'weight'         => 'decimal:2',
            'height'         => 'decimal:2',
        ];
    }

    // Function ini menjelaskan hubungan data ini dengan akun user.
    // Dengan relasi ini, sistem bisa mengambil akun login yang terhubung ke data tersebut.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Function ini menjelaskan bahwa satu siswa bisa memiliki beberapa data orang tua atau wali.
    // Data yang dimaksud bisa berupa ayah, ibu, atau wali.
    public function parents()
    {
        return $this->hasMany(Parents::class, 'student_id');
    }

    // Function ini menjelaskan bahwa satu siswa bisa memiliki beberapa dokumen.
    // Contohnya dokumen akta kelahiran, kartu keluarga, atau foto.
    public function files()
    {
        return $this->hasMany(StudentFile::class, 'student_id');
    }

    // Function ini menjelaskan riwayat kelas yang pernah atau sedang diikuti siswa.
    // Relasi ini penting untuk mengetahui siswa berada di kelas dan tahun ajaran mana.
    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'student_id');
    }

    // Function ini menjelaskan daftar jadwal konseling pribadi yang terkait dengan data ini.
    // Jadwal ini bisa dibuat oleh guru atau diajukan oleh orang tua.
    public function privateCounselingSchedules()
    {
        return $this->hasMany(PrivateCounselingSchedule::class, 'student_id');
    }
}

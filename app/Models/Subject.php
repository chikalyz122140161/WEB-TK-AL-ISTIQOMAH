"model untuk mata pelajaran sekolah. Fungsinya adalah menyimpan nama-nama mata pelajaran yang ada di sekolah, seperti Matematika, Bahasa Indonesia, IPA, IPS, Bahasa Inggris, dan lainnya. File ini menghubungkan setiap mata pelajaran ke kelas-tahun ajaran (untuk tahu mata pelajaran apa yang diajarkan di kelas mana) dan ke rapor (untuk menyimpan nilai mata pelajaran setiap siswa). Jadi sistem tahu ada mata pelajaran apa saja, diajarkan di kelas mana, dan nilai siapa saja untuk setiap mata pelajaran itu."
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'subject';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    // Function ini menjelaskan hubungan data ini dengan class term.
    // Class term adalah gabungan kelas dengan tahun ajaran atau semester tertentu.
    public function classTerms()
    {
        return $this->hasMany(ClassTermSubject::class, 'subject_id');
    }

    // Function ini menjelaskan detail rapot yang berhubungan dengan mata pelajaran.
    // Relasi ini dipakai untuk menyimpan deskripsi atau catatan guru per mapel.
    public function reportSubjects()
    {
        return $this->hasMany(ReportSubject::class, 'subject_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extracurricular extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'extracurricular';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    // Function ini menjelaskan daftar aspek penilaian yang dimiliki data ini.
    // Aspek ini dipakai guru saat memberi nilai perkembangan siswa.
    public function assessments()
    {
        return $this->hasMany(ExtracurricularAssessment::class, 'extracurricular_id');
    }

    // Function ini menjelaskan hubungan data ini dengan class term.
    // Class term adalah gabungan kelas dengan tahun ajaran atau semester tertentu.
    public function classTerms()
    {
        return $this->hasMany(ClassTermExtracurricular::class, 'extracurricular_id');
    }

    // Function ini menjelaskan detail rapot yang berhubungan dengan ekstrakurikuler.
    // Relasi ini dipakai untuk menyimpan nilai dan catatan ekskul siswa.
    public function reportExtracurriculars()
    {
        return $this->hasMany(ReportExtracurricular::class, 'extracurricular_id');
    }
}

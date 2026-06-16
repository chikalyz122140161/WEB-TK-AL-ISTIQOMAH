<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counseling extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'counseling';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    // Function ini menjelaskan daftar aspek penilaian yang dimiliki data ini.
    // Aspek ini dipakai guru saat memberi nilai perkembangan siswa.
    public function assessments()
    {
        return $this->hasMany(CounselingAssessment::class, 'counseling_id');
    }

    // Function ini menjelaskan hubungan data ini dengan class term.
    // Class term adalah gabungan kelas dengan tahun ajaran atau semester tertentu.
    public function classTerms()
    {
        return $this->hasMany(ClassTermCounseling::class, 'counseling_id');
    }

    // Function ini menjelaskan detail rapot yang berhubungan dengan konseling.
    // Relasi ini dipakai untuk menyimpan nilai perkembangan BK siswa.
    public function reportCounselings()
    {
        return $this->hasMany(ReportCounseling::class, 'counseling_id');
    }
}

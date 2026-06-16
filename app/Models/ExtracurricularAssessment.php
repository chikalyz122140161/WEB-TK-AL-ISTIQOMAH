<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtracurricularAssessment extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'extracurricular_assessment';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['extracurricular_id', 'name'];

    // Function ini menghubungkan data ini dengan satu ekstrakurikuler.
    // Dengan relasi ini sistem bisa mengambil nama dan aspek penilaian ekstrakurikuler.
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }

    // Function ini menjelaskan daftar nilai atau skor yang terkait dengan data ini.
    // Relasi ini dipakai untuk membaca hasil penilaian siswa.
    public function scores()
    {
        return $this->hasMany(ReportExtracurricularScore::class, 'extracurricular_assessment_id');
    }
}

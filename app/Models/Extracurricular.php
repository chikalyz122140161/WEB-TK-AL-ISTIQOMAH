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

    public function assessments()
    {
        return $this->hasMany(ExtracurricularAssessment::class, 'extracurricular_id');
    }

    public function classTerms()
    {
        return $this->hasMany(ClassTermExtracurricular::class, 'extracurricular_id');
    }

    public function reportExtracurriculars()
    {
        return $this->hasMany(ReportExtracurricular::class, 'extracurricular_id');
    }
}

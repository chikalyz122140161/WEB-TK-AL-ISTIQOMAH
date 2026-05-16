<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportExtracurricularScore extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_extracurricular_score';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'report_extracurricular_id',
        'extracurricular_assessment_id',
        'level',
    ];

    public function reportExtracurricular()
    {
        return $this->belongsTo(ReportExtracurricular::class, 'report_extracurricular_id');
    }

    public function assessment()
    {
        return $this->belongsTo(ExtracurricularAssessment::class, 'extracurricular_assessment_id');
    }
}

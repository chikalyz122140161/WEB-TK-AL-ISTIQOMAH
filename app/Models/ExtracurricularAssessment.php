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

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }

    public function scores()
    {
        return $this->hasMany(ReportExtracurricularScore::class, 'extracurricular_assessment_id');
    }
}

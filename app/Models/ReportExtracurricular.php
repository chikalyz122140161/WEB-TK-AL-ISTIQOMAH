<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportExtracurricular extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_extracurricular';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['report_id', 'extracurricular_id'];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }

    public function scores()
    {
        return $this->hasMany(ReportExtracurricularScore::class, 'report_extracurricular_id');
    }
}

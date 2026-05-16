<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_enrollment_id'];

    public function studentEnrollment()
    {
        return $this->belongsTo(StudentEnrollment::class, 'student_enrollment_id');
    }

    public function subjects()
    {
        return $this->hasMany(ReportSubject::class, 'report_id');
    }

    public function extracurriculars()
    {
        return $this->hasMany(ReportExtracurricular::class, 'report_id');
    }

    public function counselings()
    {
        return $this->hasMany(ReportCounseling::class, 'report_id');
    }
}

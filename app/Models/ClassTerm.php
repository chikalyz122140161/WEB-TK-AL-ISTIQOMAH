<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTerm extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_id', 'academic_term_id', 'isPass'];

    protected function casts(): array
    {
        return ['isPass' => 'boolean'];
    }

    public function class()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function academicTerm()
    {
        return $this->belongsTo(AcademicTerm::class, 'academic_term_id');
    }

    public function classSchedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_term_id');
    }

    public function activitySchedules()
    {
        return $this->hasMany(ActivitySchedule::class, 'class_term_id');
    }

    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'class_term_id');
    }

    public function subjects()
    {
        return $this->hasMany(ClassTermSubject::class, 'class_term_id');
    }

    public function extracurriculars()
    {
        return $this->hasMany(ClassTermExtracurricular::class, 'class_term_id');
    }

    public function counselings()
    {
        return $this->hasMany(ClassTermCounseling::class, 'class_term_id');
    }

    public function privateCounselingSchedules()
    {
        return $this->hasMany(PrivateCounselingSchedule::class, 'class_term_id');
    }
}

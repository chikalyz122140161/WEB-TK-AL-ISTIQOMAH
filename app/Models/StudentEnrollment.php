<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentEnrollment extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'student_enrollment';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_id', 'class_term_id', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'student_class_id');
    }

    public function report()
    {
        return $this->hasOne(Report::class, 'student_enrollment_id');
    }
}

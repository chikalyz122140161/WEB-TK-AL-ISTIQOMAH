<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateCounselingSchedule extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'private_counseling_schedule';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'class_term_id',
        'status',
        'date',
        'start_hour',
        'end_hour',
        'topic',
        'source',
    ];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    // student_id FK references user.id (the orang tua's user account)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // actual child/student record found via user_id = student_id
    public function childStudent()
    {
        return $this->hasOne(Student::class, 'user_id', 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }
}

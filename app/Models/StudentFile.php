<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFile extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'student_file';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_id', 'type'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

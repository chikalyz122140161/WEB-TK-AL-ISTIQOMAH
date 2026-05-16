<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presence extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'presence';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_class_id', 'date', 'attendance', 'description'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function studentEnrollment()
    {
        return $this->belongsTo(StudentEnrollment::class, 'student_class_id');
    }
}

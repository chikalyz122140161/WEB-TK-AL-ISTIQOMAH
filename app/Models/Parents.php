<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parents extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'parent';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id', 'category', 'name', 'work', 'education', 'pob', 'dob',
    ];

    protected function casts(): array
    {
        return ['dob' => 'date'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

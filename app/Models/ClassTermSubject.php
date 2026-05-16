<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTermSubject extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term_subject';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'subject_id'];

    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}

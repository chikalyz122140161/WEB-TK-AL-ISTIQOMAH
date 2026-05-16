<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'subject';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    public function classTerms()
    {
        return $this->hasMany(ClassTermSubject::class, 'subject_id');
    }

    public function reportSubjects()
    {
        return $this->hasMany(ReportSubject::class, 'subject_id');
    }
}

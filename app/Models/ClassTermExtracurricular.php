<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTermExtracurricular extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term_extracurricular';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'extracurricular_id'];

    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }
}

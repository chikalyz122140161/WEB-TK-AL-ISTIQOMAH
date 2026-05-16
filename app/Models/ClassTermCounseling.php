<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTermCounseling extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term_counseling';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'counseling_id'];

    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    public function counseling()
    {
        return $this->belongsTo(Counseling::class, 'counseling_id');
    }
}

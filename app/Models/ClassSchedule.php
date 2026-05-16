<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_schedule';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'name', 'day', 'hour'];

    protected function casts(): array
    {
        return ['day' => 'integer'];
    }

    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }
}

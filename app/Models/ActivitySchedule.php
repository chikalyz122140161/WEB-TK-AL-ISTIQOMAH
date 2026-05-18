<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivitySchedule extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'activity_schedule';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'name', 'date', 'start_hour', 'end_hour', 'location', 'description'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }
}

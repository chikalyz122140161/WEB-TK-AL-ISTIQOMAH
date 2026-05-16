<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'maximum'];

    protected function casts(): array
    {
        return ['maximum' => 'integer'];
    }

    public function classTerms()
    {
        return $this->hasMany(ClassTerm::class, 'class_id');
    }
}

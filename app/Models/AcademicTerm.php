<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicTerm extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'academic_term';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['academic_year', 'semester', 'status'];

    public function classTerms()
    {
        return $this->hasMany(ClassTerm::class, 'academic_term_id');
    }
}

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

    // Function ini menjelaskan hubungan data ini dengan class term.
    // Class term adalah gabungan kelas dengan tahun ajaran atau semester tertentu.
    public function classTerms()
    {
        return $this->hasMany(ClassTerm::class, 'academic_term_id');
    }
}

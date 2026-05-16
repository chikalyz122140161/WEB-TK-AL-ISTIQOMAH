<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counseling extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'counseling';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    public function assessments()
    {
        return $this->hasMany(CounselingAssessment::class, 'counseling_id');
    }

    public function classTerms()
    {
        return $this->hasMany(ClassTermCounseling::class, 'counseling_id');
    }

    public function reportCounselings()
    {
        return $this->hasMany(ReportCounseling::class, 'counseling_id');
    }
}

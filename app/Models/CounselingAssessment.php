<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounselingAssessment extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'counseling_assessment';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['counseling_id', 'name'];

    public function counseling()
    {
        return $this->belongsTo(Counseling::class, 'counseling_id');
    }

    public function scores()
    {
        return $this->hasMany(ReportCounselingScore::class, 'counseling_assessment_id');
    }
}

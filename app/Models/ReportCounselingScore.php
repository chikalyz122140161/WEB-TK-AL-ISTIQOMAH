<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportCounselingScore extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_counseling_score';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'report_counseling_id',
        'counseling_assessment_id',
        'level',
        'week',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'week' => 'integer',
            'date' => 'date',
        ];
    }

    public function reportCounseling()
    {
        return $this->belongsTo(ReportCounseling::class, 'report_counseling_id');
    }

    public function assessment()
    {
        return $this->belongsTo(CounselingAssessment::class, 'counseling_assessment_id');
    }
}

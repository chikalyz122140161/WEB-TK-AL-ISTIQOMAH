<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportCounseling extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_counseling';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['report_id', 'counseling_id'];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function counseling()
    {
        return $this->belongsTo(Counseling::class, 'counseling_id');
    }

    public function scores()
    {
        return $this->hasMany(ReportCounselingScore::class, 'report_counseling_id');
    }
}

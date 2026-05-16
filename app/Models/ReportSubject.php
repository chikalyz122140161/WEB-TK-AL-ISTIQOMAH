<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportSubject extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_subject';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['report_id', 'subject_id', 'description'];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function images()
    {
        return $this->hasMany(ReportSubjectImage::class, 'report_subject_id');
    }
}

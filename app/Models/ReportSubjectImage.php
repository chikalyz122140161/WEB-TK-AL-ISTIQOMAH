<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportSubjectImage extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_subject_image';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['report_subject_id', 'description'];

    public function reportSubject()
    {
        return $this->belongsTo(ReportSubject::class, 'report_subject_id');
    }
}

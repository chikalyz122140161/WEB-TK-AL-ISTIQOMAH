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

    // Function ini menghubungkan data ini dengan rapot siswa.
    // Relasi ini dipakai untuk mengambil atau menyimpan hasil rapot.
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    // Function ini menghubungkan data ini dengan satu mata pelajaran.
    // Dengan relasi ini nama mata pelajaran bisa diambil dari database.
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Function ini menjelaskan relasi atau fungsi {images} pada model ini.
    // Biasanya function model dipakai untuk menghubungkan tabel satu dengan tabel lain di database.
    public function images()
    {
        return $this->hasMany(ReportSubjectImage::class, 'report_subject_id');
    }
}

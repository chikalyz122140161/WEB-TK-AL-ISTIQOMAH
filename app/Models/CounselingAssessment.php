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

    // Function ini menghubungkan data ini dengan satu jenis konseling.
    // Dengan relasi ini sistem bisa mengambil nama konseling dan aspek penilaiannya.
    public function counseling()
    {
        return $this->belongsTo(Counseling::class, 'counseling_id');
    }

    // Function ini menjelaskan daftar nilai atau skor yang terkait dengan data ini.
    // Relasi ini dipakai untuk membaca hasil penilaian siswa.
    public function scores()
    {
        return $this->hasMany(ReportCounselingScore::class, 'counseling_assessment_id');
    }
}

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

    // Function ini menghubungkan data ini dengan rapot siswa.
    // Relasi ini dipakai untuk mengambil atau menyimpan hasil rapot.
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

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
        return $this->hasMany(ReportCounselingScore::class, 'report_counseling_id');
    }
}

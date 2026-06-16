"model untuk nilai ekstrakurikuler dalam rapor siswa. Fungsinya adalah menghubungkan satu jenis ekstrakurikuler ke rapor siswa tertentu. Jadi jika rapor siswa berisi nilai untuk 2-3 ekstrakurikuler (misalnya: Olahraga, Seni, Musik), file ini mencatat setiap ekstrakurikuler tersebut. File ini juga menghubungkan ke nilai-nilai detail setiap aspek ekstrakurikuler itu. Jadi sistem tahu ekstrakurikuler apa saja yang ada di rapor, dan nilai aspek apa saja dari setiap ekstrakurikuler tersebut."

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportExtracurricular extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_extracurricular';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['report_id', 'extracurricular_id'];

    // Function ini menghubungkan data ini dengan rapot siswa.
    // Relasi ini dipakai untuk mengambil atau menyimpan hasil rapot.
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    // Function ini menghubungkan data ini dengan satu ekstrakurikuler.
    // Dengan relasi ini sistem bisa mengambil nama dan aspek penilaian ekstrakurikuler.
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }

    // Function ini menjelaskan daftar nilai atau skor yang terkait dengan data ini.
    // Relasi ini dipakai untuk membaca hasil penilaian siswa.
    public function scores()
    {
        return $this->hasMany(ReportExtracurricularScore::class, 'report_extracurricular_id');
    }
}

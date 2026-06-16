"jenis-jenis konseling (BK). Fungsinya adalah menyimpan nama konseling apa saja yang ada di sekolah. Konseling ini memiliki aspek-aspek penilaian yang digunakan guru untuk memberi nilai kepada siswa. File ini juga menghubungkan konseling ke kelas-tahun ajaran (untuk tahu konseling apa yang diajarkan di kelas mana) dan ke rapor (untuk menyimpan nilai BK siswa). Jadi sistem tahu ada konseling apa, dinilai dengan cara apa, dan nilai siapa saja yang sudah diinput"
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

    // Function ini menjelaskan daftar aspek penilaian yang dimiliki data ini.
    // Aspek ini dipakai guru saat memberi nilai perkembangan siswa.
    public function assessments()
    {
        return $this->hasMany(CounselingAssessment::class, 'counseling_id');
    }

    // Function ini menjelaskan hubungan data ini dengan class term.
    // Class term adalah gabungan kelas dengan tahun ajaran atau semester tertentu.
    public function classTerms()
    {
        return $this->hasMany(ClassTermCounseling::class, 'counseling_id');
    }

    // Function ini menjelaskan detail rapot yang berhubungan dengan konseling.
    // Relasi ini dipakai untuk menyimpan nilai perkembangan BK siswa.
    public function reportCounselings()
    {
        return $this->hasMany(ReportCounseling::class, 'counseling_id');
    }
}

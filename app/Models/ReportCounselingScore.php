
"model untuk nilai detail setiap aspek konseling. Fungsinya adalah menyimpan nilai/skor siswa untuk satu aspek konseling tertentu. Contohnya, jika aspek konseling adalah "Kedisiplinan", file ini mencatat berapa level/skor siswa itu (seperti level 1, 2, 3, atau 4), kapan diberi nilai (tanggal dan minggu ke berapa). File ini menghubungkan ke konseling-nya dan aspek penilaiannya. Jadi sistem tahu siswa mendapat nilai berapa untuk aspek apa, kapan diberikan, dan masuk ke rapor konseling mana"
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

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return [
            'week' => 'integer',
            'date' => 'date',
        ];
    }

    // Function ini menghubungkan skor dengan detail konseling pada rapot.
    // Relasi ini membantu sistem mengetahui nilai tersebut masuk ke bagian konseling mana.
    public function reportCounseling()
    {
        return $this->belongsTo(ReportCounseling::class, 'report_counseling_id');
    }

    // Function ini menjelaskan relasi atau fungsi {assessment} pada model ini.
    // Biasanya function model dipakai untuk menghubungkan tabel satu dengan tabel lain di database.
    public function assessment()
    {
        return $this->belongsTo(CounselingAssessment::class, 'counseling_assessment_id');
    }
}

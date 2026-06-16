"model untuk nilai detail setiap aspek ekstrakurikuler. Fungsinya adalah menyimpan nilai/skor siswa untuk satu aspek ekstrakurikuler tertentu. Contohnya, jika siswa mengikuti ekstrakurikuler Olahraga dengan aspek penilaian "Keterampilan" dan "Kerja Sama", file ini mencatat berapa level/skor siswa itu untuk setiap aspek (seperti level 1, 2, 3, atau 4). File ini menghubungkan ke ekstrakurikuler-nya dan aspek penilaiannya. Jadi sistem tahu siswa mendapat nilai berapa untuk aspek apa, dan masuk ke rapor ekstrakurikuler mana."
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportExtracurricularScore extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_extracurricular_score';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'report_extracurricular_id',
        'extracurricular_assessment_id',
        'level',
    ];

    // Function ini menghubungkan skor dengan detail ekstrakurikuler pada rapot.
    // Relasi ini membantu sistem mengetahui nilai tersebut masuk ke bagian ekskul mana.
    public function reportExtracurricular()
    {
        return $this->belongsTo(ReportExtracurricular::class, 'report_extracurricular_id');
    }

    // Function ini menjelaskan relasi atau fungsi {assessment} pada model ini.
    // Biasanya function model dipakai untuk menghubungkan tabel satu dengan tabel lain di database.
    public function assessment()
    {
        return $this->belongsTo(ExtracurricularAssessment::class, 'extracurricular_assessment_id');
    }
}

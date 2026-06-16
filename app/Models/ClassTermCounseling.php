"menghubungkan konseling dengan kelas dan tahun ajaran. membuat catatan bahwa konseling apa saja yang diajarkan di kelas tertentu pada tahun ajaran tertentu. File ini hanya menghubungkan dua data: kelas-tahun ajaran dan jenis konseling. Jadi sistemnya tahu konseling apa yang tersedia untuk setiap kelas"
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTermCounseling extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term_counseling';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'counseling_id'];

    // Function ini menjelaskan hubungan data ini dengan satu class term.
    // Dari relasi ini sistem bisa mengetahui kelas dan semester yang sedang dipakai.
    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    // Function ini menghubungkan data ini dengan satu jenis konseling.
    // Dengan relasi ini sistem bisa mengambil nama konseling dan aspek penilaiannya.
    public function counseling()
    {
        return $this->belongsTo(Counseling::class, 'counseling_id');
    }
}

"menghubungkan ekstrakurikuler dengan kelas dan tahun ajaran. Fungsinya adalah membuat catatan ekstrakurikuler apa saja yang tersedia di kelas tertentu pada tahun ajaran tertentu. File ini menghubungkan dua data: kelas-tahun ajaran dan jenis ekstrakurikuler. Jadi sistem tahu kegiatan ekstrakurikuler apa (seperti olahraga, seni, musik) yang bisa diikuti siswa di setiap kelas."
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTermExtracurricular extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term_extracurricular';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'extracurricular_id'];

    // Function ini menjelaskan hubungan data ini dengan satu class term.
    // Dari relasi ini sistem bisa mengetahui kelas dan semester yang sedang dipakai.
    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    // Function ini menghubungkan data ini dengan satu ekstrakurikuler.
    // Dengan relasi ini sistem bisa mengambil nama dan aspek penilaian ekstrakurikuler.
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class, 'extracurricular_id');
    }
}

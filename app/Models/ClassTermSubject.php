"menghubungkan mata pelajaran dengan kelas dan tahun ajaran. Fungsinya adalah membuat catatan mata pelajaran apa saja yang diajarkan di kelas tertentu pada tahun ajaran tertentu. File ini menghubungkan dua data: kelas-tahun ajaran dan mata pelajaran. Jadi sistem tahu pelajaran apa (seperti Matematika, Bahasa Indonesia, IPA) yang diajarkan di setiap kelas."
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTermSubject extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_term_subject';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'subject_id'];

    // Function ini menjelaskan hubungan data ini dengan satu class term.
    // Dari relasi ini sistem bisa mengetahui kelas dan semester yang sedang dipakai.
    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }

    // Function ini menghubungkan data ini dengan satu mata pelajaran.
    // Dengan relasi ini nama mata pelajaran bisa diambil dari database.
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}

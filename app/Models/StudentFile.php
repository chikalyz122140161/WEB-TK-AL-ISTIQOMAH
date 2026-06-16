"model untuk dokumen/file siswa. Fungsinya adalah menyimpan berkas-berkas penting siswa seperti fotokopi akta kelahiran, kartu keluarga, foto siswa, sertifikat vaksin, atau dokumen lainnya. Setiap file menyimpan: siswa siapa, tipe dokumen apa (akta, kartu keluarga, foto, dll), dan di mana file itu disimpan (path/lokasi file). File ini menghubungkan setiap dokumen ke siswa. Jadi sistem tahu dokumen apa saja yang dimiliki setiap siswa dan di mana file-file itu tersimpan."

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFile extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'student_file';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['student_id', 'type', 'path'];

    // Function ini menjelaskan hubungan data ini dengan data siswa.
    // Relasi ini dipakai saat sistem perlu mengetahui siswa yang terkait dengan data tersebut.
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

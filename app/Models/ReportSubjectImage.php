"model untuk gambar/foto kegiatan pembelajaran mata pelajaran. Fungsinya adalah menyimpan foto-foto pembelajaran yang diupload guru untuk setiap mata pelajaran di rapor. Contohnya, guru bisa upload foto siswa saat praktik di lab, sedang mengerjakan proyek, atau hasil karya siswa. Setiap foto bisa diberi keterangan atau deskripsi. File ini menghubungkan setiap foto ke mata pelajaran-nya di rapor. Jadi sistem tahu foto apa saja yang ada untuk mata pelajaran apa, dan foto-foto itu menunjukkan bukti pembelajaran siswa."
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportSubjectImage extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'report_subject_image';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['report_subject_id', 'description'];

    // Function ini menghubungkan gambar dengan detail mata pelajaran pada rapot.
    // Relasi ini dipakai saat guru menambahkan foto kegiatan.
    public function reportSubject()
    {
        return $this->belongsTo(ReportSubject::class, 'report_subject_id');
    }
}

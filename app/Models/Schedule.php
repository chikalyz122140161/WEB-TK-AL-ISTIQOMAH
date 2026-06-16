"model untuk jadwal kegiatan siswa dan guru. Fungsinya adalah menyimpan jadwal-jadwal tertentu, bisa jadwal les tambahan, jadwal konseling pribadi, atau jadwal kegiatan lain antara siswa dan guru. Setiap jadwal menyimpan: siswa siapa, guru siapa, tipe jadwal apa (les, konseling, dll), kapan tanggalnya, dan deskripsi/keterangan jadwal. File ini menghubungkan siswa dan guru. Jadi sistem tahu ada jadwal apa saja antara siswa dan guru mana"

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'teacher_id', 'type', 'date', 'description',
    ];

    // Function ini menjelaskan hubungan data ini dengan data siswa.
    // Relasi ini dipakai saat sistem perlu mengetahui siswa yang terkait dengan data tersebut.
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Function ini menghubungkan data ini dengan user guru.
    // Dengan relasi ini sistem bisa menampilkan siapa guru yang bertanggung jawab.
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}

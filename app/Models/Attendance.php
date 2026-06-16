<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'teacher_id', 'date', 'status', 'note',
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

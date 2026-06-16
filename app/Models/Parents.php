"data orang tua atau wali siswa. Fungsinya adalah menyimpan informasi lengkap tentang orang tua, seperti: nama, pekerjaan, pendidikan, tempat lahir, dan tanggal lahir. Setiap orang tua terhubung dengan satu siswa tertentu. File ini juga mencatat kategori orang tua (apakah ayah, ibu, atau wali). Jadi sistem tahu data lengkap orang tua masing-masing siswa."

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parents extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'parent';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id', 'category', 'name', 'work', 'education', 'pob', 'dob',
    ];

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return ['dob' => 'date'];
    }

    // Function ini menjelaskan hubungan data ini dengan data siswa.
    // Relasi ini dipakai saat sistem perlu mengetahui siswa yang terkait dengan data tersebut.
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

"model untuk akun login pengguna sistem. Fungsinya adalah menyimpan data akun setiap pengguna (guru, admin, orang tua, siswa), termasuk: nama, email, password, telepon, role (peran/jabatan), status, dan status kelulusan. File ini punya fitur keamanan: password disembunyikan saat ditampilkan (menggunakan $hidden), dan password otomatis dienkripsi aman (hashed). File ini juga menghubungkan akun user ke data siswa (jika user adalah siswa) dan ke jadwal konseling yang ditangani (jika user adalah guru). Jadi sistem tahu siapa saja yang login, peran mereka apa, dan data apa saja yang terkait dengan akun mereka."
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $table = 'user';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'isGraduate',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return [
            'password'    => 'hashed',
            'isGraduate'  => 'boolean',
        ];
    }

    // Function ini menjelaskan hubungan data ini dengan data siswa.
    // Relasi ini dipakai saat sistem perlu mengetahui siswa yang terkait dengan data tersebut.
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    // Function ini menjelaskan jadwal konseling yang ditangani oleh user guru.
    // Relasi ini dipakai untuk melihat daftar konseling berdasarkan guru yang bertugas.
    public function privateCounselingSchedulesAsTeacher()
    {
        return $this->hasMany(PrivateCounselingSchedule::class, 'teacher_id');
    }
}

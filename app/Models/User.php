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

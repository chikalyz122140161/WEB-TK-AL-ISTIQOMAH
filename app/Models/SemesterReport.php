<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'tahun_ajaran',
        'semester',
        'kelas',
        'agama_moral',
        'agama_moral_deskripsi',
        'fisik_motorik',
        'fisik_motorik_deskripsi',
        'kognitif',
        'kognitif_deskripsi',
        'bahasa',
        'bahasa_deskripsi',
        'sosial_emosional',
        'sosial_emosional_deskripsi',
        'seni',
        'seni_deskripsi',
        'hadir',
        'izin',
        'sakit',
        'alpa',
        'catatan_guru',
        'rekomendasi',
        'tanggal_terbit',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
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

    // Function ini mengubah kode nilai rapot menjadi tulisan yang lebih mudah dipahami.
    // Contohnya kode seperti BB, MB, BSH, atau BSB dibuat menjadi label penilaian.
    public static function getNilaiLabel($nilai)
    {
        return match($nilai) {
            'BB' => 'Belum Berkembang',
            'MB' => 'Mulai Berkembang',
            'BSH' => 'Berkembang Sesuai Harapan',
            'BSB' => 'Berkembang Sangat Baik',
            default => '-'
        };
    }

    // Function ini menentukan warna tampilan berdasarkan nilai rapot.
    // Tujuannya agar nilai lebih mudah dibedakan secara visual di halaman.
    public static function getNilaiColor($nilai)
    {
        return match($nilai) {
            'BB' => '#ef4444',
            'MB' => '#f59e0b',
            'BSH' => '#10b981',
            'BSB' => '#3b82f6',
            default => '#6b7280'
        };
    }
}

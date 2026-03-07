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

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Helper untuk mendapatkan label nilai
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

    // Helper untuk warna badge
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

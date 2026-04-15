<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_siswa',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pendidikan_ayah',
        'pekerjaan_ibu',
        'pendidikan_ibu',
        'telepon',
        'email',
        'alamat_ortu',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function dokumen()
    {
        return $this->hasMany(DokumenPendaftaran::class);
    }
}
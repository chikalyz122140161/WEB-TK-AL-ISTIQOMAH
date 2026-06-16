" data pendaftaran calon siswa baru. Fungsinya adalah menyimpan semua informasi dari formulir pendaftaran, termasuk: data siswa (nama, NIK, tanggal lahir, alamat, kesehatan), data orang tua (ayah, ibu, wali dengan nama, pekerjaan, pendidikan, telepon), dan data administrasi (kode pendaftaran, status, catatan admin). File ini juga menghubungkan ke dokumen-dokumen yang diupload calon siswa (seperti fotokopi akta, kartu keluarga, dll). Jadi sistem tahu data lengkap calon siswa dan berkas apa saja yang sudah diupload."
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pendaftaran',
        'nik',
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat_siswa',
        'anak_ke',
        'jumlah_saudara',
        'suku_bangsa',
        'riwayat_penyakit',
        'berat_badan',
        'tinggi_badan',
        'nama_ayah',
        'pekerjaan_ayah',
        'pendidikan_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'no_telp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'pendidikan_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'no_telp_ibu',
        'nama_wali',
        'pekerjaan_wali',
        'pendidikan_wali',
        'tempat_lahir_wali',
        'tanggal_lahir_wali',
        'no_telp_wali',
        'telepon',
        'email',
        'password_ortu',
        'alamat_ortu',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_lahir'      => 'date',
        'tanggal_lahir_ayah' => 'date',
        'tanggal_lahir_ibu'  => 'date',
        'tanggal_lahir_wali' => 'date',
        'anak_ke'            => 'integer',
        'jumlah_saudara'     => 'integer',
        'berat_badan'        => 'decimal:2',
        'tinggi_badan'       => 'decimal:2',
    ];

    // Function ini menjelaskan dokumen yang terhubung dengan data pendaftaran.
    // Relasi ini dipakai untuk melihat berkas yang diupload calon siswa.
    public function dokumen()
    {
        return $this->hasMany(DokumenPendaftaran::class);
    }
}

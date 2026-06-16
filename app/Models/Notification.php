"pemberitahuan atau notifikasi. Fungsinya adalah menyimpan pesan-pesan penting untuk dikirim ke user (pengguna sistem). Setiap notifikasi menyimpan: siapa user yang menerima, apa pesan yang dikirim, dan apakah sudah dibaca atau belum. File ini menghubungkan notifikasi ke akun user. Jadi sistem tahu notifikasi apa yang sudah dikirim ke siapa dan notifikasi mana yang sudah dibaca."
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'message', 'read',
    ];

    // Function ini menjelaskan hubungan data ini dengan akun user.
    // Dengan relasi ini, sistem bisa mengambil akun login yang terhubung ke data tersebut.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

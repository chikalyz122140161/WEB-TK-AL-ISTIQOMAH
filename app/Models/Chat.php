" membantu sistem memahami setiap pesan berasal dari siapa dan ditujukan kepada siapa."
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', 'receiver_id', 'message', 'is_read',
    ];

    // Function ini menghubungkan pesan dengan user pengirim.
    // Relasi ini dipakai untuk membedakan pesan milik sendiri dan pesan dari lawan bicara.
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Function ini menghubungkan pesan dengan user penerima.
    // Relasi ini dipakai agar sistem tahu pesan ditujukan kepada siapa.
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

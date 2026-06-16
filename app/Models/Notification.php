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

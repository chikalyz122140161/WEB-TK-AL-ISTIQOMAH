<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pendaftaran';

    protected $fillable = [
        'registration_id',
        'jenis_dokumen',
        'nama_file',
        'path',
    ];

    // Function ini menghubungkan dokumen dengan data pendaftaran.
    // Dengan relasi ini sistem tahu dokumen tersebut milik pendaftaran siapa.
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}

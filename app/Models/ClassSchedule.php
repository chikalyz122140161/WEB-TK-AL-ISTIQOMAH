<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'class_schedule';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['class_term_id', 'name', 'day', 'start_hour', 'end_hour'];

    // Function ini mengatur tipe data otomatis pada field model.
    // Jadi saat data dibaca dari database, Laravel langsung mengubahnya ke tipe yang sesuai seperti tanggal, angka, atau boolean.
    protected function casts(): array
    {
        return ['day' => 'integer'];
    }

    // Function ini menjelaskan hubungan data ini dengan satu class term.
    // Dari relasi ini sistem bisa mengetahui kelas dan semester yang sedang dipakai.
    public function classTerm()
    {
        return $this->belongsTo(ClassTerm::class, 'class_term_id');
    }
}

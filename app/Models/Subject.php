<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'subject';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    // Function ini menjelaskan hubungan data ini dengan class term.
    // Class term adalah gabungan kelas dengan tahun ajaran atau semester tertentu.
    public function classTerms()
    {
        return $this->hasMany(ClassTermSubject::class, 'subject_id');
    }

    // Function ini menjelaskan detail rapot yang berhubungan dengan mata pelajaran.
    // Relasi ini dipakai untuk menyimpan deskripsi atau catatan guru per mapel.
    public function reportSubjects()
    {
        return $this->hasMany(ReportSubject::class, 'subject_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatRoom extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'chat_room';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['user_a_id', 'user_b_id'];

    // Function ini menghubungkan ruang chat dengan user pertama.
    // Ruang chat memakai dua user agar percakapan bisa dibedakan antar pasangan pengguna.
    public function userA()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_a_id');
    }

    // Function ini menghubungkan ruang chat dengan user kedua.
    // Relasi ini dipakai bersama user pertama untuk menentukan lawan bicara.
    public function userB()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_b_id');
    }

    // Function ini menjelaskan daftar pesan dalam satu ruang chat.
    // Relasi ini dipakai untuk menampilkan riwayat percakapan.
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_room_id')->orderBy('created_at');
    }

    // Function ini mengambil pesan terakhir dari satu ruang chat.
    // Data ini dipakai untuk menampilkan preview pesan terbaru di daftar chat.
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'chat_room_id')->latestOfMany();
    }

    // Function ini menjelaskan relasi atau fungsi {otherUser} pada model ini.
    // Biasanya function model dipakai untuk menghubungkan tabel satu dengan tabel lain di database.
    public function otherUser(int|string $currentUserId)
    {
        return $this->user_a_id === $currentUserId ? $this->userB : $this->userA;
    }
}

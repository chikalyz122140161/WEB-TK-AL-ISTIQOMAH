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

    public function userA()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_a_id');
    }

    public function userB()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_b_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_room_id')->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'chat_room_id')->latestOfMany();
    }

    public function otherUser(int|string $currentUserId)
    {
        return $this->user_a_id === $currentUserId ? $this->userB : $this->userA;
    }
}

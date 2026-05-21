<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'chat_message';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['chat_room_id', 'sender_id', 'message', 'isRead'];

    protected $casts = ['isRead' => 'boolean'];

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }

    public function sender()
    {
        return $this->belongsTo(\App\Models\User::class, 'sender_id');
    }
}

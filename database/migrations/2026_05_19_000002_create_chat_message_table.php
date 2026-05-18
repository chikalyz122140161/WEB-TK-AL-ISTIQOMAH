<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_message', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('chat_room_id');
            $table->uuid('sender_id');
            $table->text('message');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('chat_room_id')->references('id')->on('chat_room')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_message');
    }
};

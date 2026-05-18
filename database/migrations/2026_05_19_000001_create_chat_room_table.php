<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_room', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_a_id');
            $table->uuid('user_b_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_a_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('user_b_id')->references('id')->on('user')->onDelete('cascade');

            $table->unique(['user_a_id', 'user_b_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_room');
    }
};

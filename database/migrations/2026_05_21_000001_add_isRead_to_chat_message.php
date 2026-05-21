<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_message', function (Blueprint $table) {
            $table->boolean('isRead')->default(false)->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('chat_message', function (Blueprint $table) {
            $table->dropColumn('isRead');
        });
    }
};

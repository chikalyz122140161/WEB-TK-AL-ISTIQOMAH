<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('private_counseling_schedule', function (Blueprint $table) {
            $table->string('source')->default('guru')->after('topic');
        });
    }

    public function down(): void
    {
        Schema::table('private_counseling_schedule', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};

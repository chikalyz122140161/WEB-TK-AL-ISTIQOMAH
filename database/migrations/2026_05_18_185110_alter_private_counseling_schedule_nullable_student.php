<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('private_counseling_schedule', function (Blueprint $table) {
            $table->uuid('student_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('private_counseling_schedule', function (Blueprint $table) {
            $table->uuid('student_id')->nullable(false)->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('class_schedule', function (Blueprint $table) {
            $table->dropColumn('hour');
            $table->time('start_hour')->after('day');
            $table->time('end_hour')->nullable()->after('start_hour');
        });
    }

    public function down(): void
    {
        Schema::table('class_schedule', function (Blueprint $table) {
            $table->dropColumn(['start_hour', 'end_hour']);
            $table->string('hour')->after('day');
        });
    }
};

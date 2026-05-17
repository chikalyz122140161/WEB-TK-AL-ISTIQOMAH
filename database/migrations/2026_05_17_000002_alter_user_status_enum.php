<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Migrate existing values first
        DB::table('user')->where('status', 'aktif')->update(['status' => 'active']);
        DB::table('user')->where('status', 'nonaktif')->update(['status' => 'inactive']);

        DB::statement("ALTER TABLE `user` MODIFY `status` ENUM('pending','active','inactive') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::table('user')->where('status', 'active')->update(['status' => 'aktif']);
        DB::table('user')->where('status', 'inactive')->update(['status' => 'nonaktif']);

        DB::statement("ALTER TABLE `user` MODIFY `status` ENUM('pending','aktif','nonaktif') NOT NULL DEFAULT 'aktif'");
    }
};

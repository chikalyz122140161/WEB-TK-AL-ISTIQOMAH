<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: expand enum to include both old + new values
        DB::statement("ALTER TABLE `private_counseling_schedule` MODIFY COLUMN `status` ENUM('pending','disetujui','ditolak','selesai','batal','approved','rejected','canceled') NOT NULL DEFAULT 'pending'");

        // Step 2: migrate existing data
        DB::table('private_counseling_schedule')->where('status', 'disetujui')->update(['status' => 'approved']);
        DB::table('private_counseling_schedule')->where('status', 'ditolak')->update(['status' => 'rejected']);
        DB::table('private_counseling_schedule')->whereIn('status', ['batal', 'selesai'])->update(['status' => 'canceled']);

        // Step 3: remove old values from enum
        DB::statement("ALTER TABLE `private_counseling_schedule` MODIFY COLUMN `status` ENUM('pending','approved','rejected','canceled') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `private_counseling_schedule` MODIFY COLUMN `status` ENUM('pending','disetujui','ditolak','selesai','batal','approved','rejected','canceled') NOT NULL DEFAULT 'pending'");

        DB::table('private_counseling_schedule')->where('status', 'approved')->update(['status' => 'disetujui']);
        DB::table('private_counseling_schedule')->where('status', 'rejected')->update(['status' => 'ditolak']);
        DB::table('private_counseling_schedule')->where('status', 'canceled')->update(['status' => 'batal']);

        DB::statement("ALTER TABLE `private_counseling_schedule` MODIFY COLUMN `status` ENUM('pending','disetujui','ditolak','selesai','batal') NOT NULL DEFAULT 'pending'");
    }
};

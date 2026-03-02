<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roles = ['admin', 'guru', 'orangtua'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Permissions (example, can be expanded)
        $permissions = [
            'crud siswa',
            'crud user',
            'backup',
            'pendaftaran luar login',
            'catat kehadiran',
            'lihat kehadiran',
            'generate laporan',
            'lihat laporan',
            'lihat jadwal',
            'tambah jadwal',
            'input perkembangan',
            'buat laporan perkembangan',
            'lihat grafik perkembangan',
            'chat',
            'kelola jadwal konseling',
            'lihat report perkembangan',
            'ajukan jadwal konseling',
            'ekspor pdf',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}

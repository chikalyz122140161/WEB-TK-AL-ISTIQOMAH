<?php

namespace App\Console\Commands;

use App\Services\DatabaseBackupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup
                            {--source=scheduled : Sumber backup (manual/scheduled)}
                            {--keep=12 : Jumlah file backup terakhir yang dipertahankan, sisanya dihapus (0 = jangan hapus apapun)}';

    protected $description = 'Membuat backup file SQL dari database TK Al-Istiqomah';

    // Function ini menjalankan proses utama saat command atau middleware dipanggil oleh Laravel.
    // Isinya menentukan langkah yang harus dilakukan sistem pada proses tersebut.
    public function handle(DatabaseBackupService $service): int
    {
        $this->info('Memulai backup database...');

        try {
            $filename = $service->create($this->option('source'));
            $this->info("Backup berhasil: {$filename}");
        } catch (\Throwable $e) {
            $this->error('Gagal membuat backup: ' . $e->getMessage());
            return self::FAILURE;
        }

        $keep = (int) $this->option('keep');
        if ($keep > 0) {
            $this->pruneOldBackups($service, $keep);
        }

        return self::SUCCESS;
    }

    // Function ini menghapus file backup lama ketika jumlah backup sudah terlalu banyak.
    // Tujuannya agar penyimpanan tidak penuh oleh file lama.
    protected function pruneOldBackups(DatabaseBackupService $service, int $keep): void
    {
        $backups = $service->list();
        if (count($backups) <= $keep) {
            return;
        }

        $toDelete = array_slice($backups, $keep);
        foreach ($toDelete as $b) {
            if (File::delete($b['path'])) {
                $this->line("Dihapus (rotasi): {$b['filename']}");
            }
        }
    }
}

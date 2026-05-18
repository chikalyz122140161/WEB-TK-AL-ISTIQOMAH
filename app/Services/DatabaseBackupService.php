<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;

class DatabaseBackupService
{
    protected string $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/private/backups');

        if (! File::isDirectory($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    public function backupPath(): string
    {
        return $this->backupPath;
    }

    /**
     * Create a new SQL dump file. Returns the filename.
     */
    public function create(string $source = 'manual'): string
    {
        $database = DB::getDatabaseName();
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $filename  = "backup_{$database}_{$timestamp}.sql";
        $fullPath  = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        $handle = fopen($fullPath, 'w');
        if ($handle === false) {
            throw new RuntimeException("Tidak dapat membuat file backup di {$fullPath}");
        }

        try {
            $this->writeHeader($handle, $database, $source);

            $tables = $this->getTables();

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
            fwrite($handle, "SET NAMES utf8mb4;\n\n");

            foreach ($tables as $table) {
                $this->dumpTable($handle, $table);
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        } catch (\Throwable $e) {
            fclose($handle);
            @unlink($fullPath);
            throw $e;
        }

        fclose($handle);

        return $filename;
    }

    /**
     * Restore database from a backup file.
     */
    public function restore(string $filename): void
    {
        $fullPath = $this->backupPath . DIRECTORY_SEPARATOR . basename($filename);

        if (! File::exists($fullPath)) {
            throw new RuntimeException("File backup tidak ditemukan: {$filename}");
        }

        $sql = File::get($fullPath);
        $statements = $this->splitStatements($sql);

        DB::unprepared('SET FOREIGN_KEY_CHECKS=0');
        try {
            foreach ($statements as $statement) {
                $trimmed = trim($statement);
                if ($trimmed === '' || str_starts_with($trimmed, '--')) {
                    continue;
                }
                DB::unprepared($trimmed);
            }
        } finally {
            DB::unprepared('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * List existing backup files (newest first).
     *
     * @return array<int, array{filename:string,path:string,size:int,size_human:string,created_at:Carbon,source:string}>
     */
    public function list(): array
    {
        if (! File::isDirectory($this->backupPath)) {
            return [];
        }

        $files = collect(File::files($this->backupPath))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.sql'))
            ->sortByDesc(fn($f) => $f->getMTime())
            ->values();

        return $files->map(function ($file) {
            return [
                'filename'   => $file->getFilename(),
                'path'       => $file->getPathname(),
                'size'       => $file->getSize(),
                'size_human' => $this->humanSize($file->getSize()),
                'created_at' => Carbon::createFromTimestamp($file->getMTime()),
                'source'     => $this->detectSource($file->getPathname()),
            ];
        })->all();
    }

    public function delete(string $filename): bool
    {
        $fullPath = $this->backupPath . DIRECTORY_SEPARATOR . basename($filename);

        if (! File::exists($fullPath)) {
            return false;
        }

        return File::delete($fullPath);
    }

    public function path(string $filename): ?string
    {
        $fullPath = $this->backupPath . DIRECTORY_SEPARATOR . basename($filename);
        return File::exists($fullPath) ? $fullPath : null;
    }

    // ─── Internal helpers ──────────────────────────────────────────────

    protected function writeHeader($handle, string $database, string $source): void
    {
        $now = Carbon::now()->toDateTimeString();
        fwrite($handle, "-- ====================================================\n");
        fwrite($handle, "-- TK Al-Istiqomah Database Backup\n");
        fwrite($handle, "-- Database : {$database}\n");
        fwrite($handle, "-- Created  : {$now}\n");
        fwrite($handle, "-- Source   : {$source}\n");
        fwrite($handle, "-- ====================================================\n\n");
    }

    /** @return array<int, string> */
    protected function getTables(): array
    {
        $rows = DB::select('SHOW TABLES');
        $key  = 'Tables_in_' . DB::getDatabaseName();
        return array_map(fn($r) => $r->{$key} ?? array_values((array) $r)[0], $rows);
    }

    protected function dumpTable($handle, string $table): void
    {
        fwrite($handle, "-- ---------- Table: {$table} ----------\n");
        fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");

        $createRow = DB::select("SHOW CREATE TABLE `{$table}`");
        $createSql = (array) $createRow[0];
        $createSql = $createSql['Create Table'] ?? $createSql['Create View'] ?? '';
        fwrite($handle, $createSql . ";\n\n");

        // Stream rows in chunks to avoid memory blow-up
        DB::table($table)->orderBy(DB::raw('1'))->chunk(500, function ($rows) use ($handle, $table) {
            foreach ($rows as $row) {
                $columns = array_keys((array) $row);
                $values  = array_map(
                    fn($v) => $this->quoteValue($v),
                    array_values((array) $row)
                );
                $colList = implode('`, `', $columns);
                $valList = implode(', ', $values);
                fwrite($handle, "INSERT INTO `{$table}` (`{$colList}`) VALUES ({$valList});\n");
            }
        });

        fwrite($handle, "\n");
    }

    protected function quoteValue($value): string
    {
        if ($value === null) {
            return 'NULL';
        }
        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }
        return "'" . str_replace(
            ["\\", "'", "\n", "\r", "\0", "\x1a"],
            ["\\\\", "\\'", "\\n", "\\r", "\\0", "\\Z"],
            (string) $value
        ) . "'";
    }

    /** @return array<int, string> */
    protected function splitStatements(string $sql): array
    {
        $statements = [];
        $buffer = '';
        $inString = false;
        $stringChar = '';
        $len = strlen($sql);

        for ($i = 0; $i < $len; $i++) {
            $ch = $sql[$i];
            $prev = $i > 0 ? $sql[$i - 1] : '';

            if ($inString) {
                $buffer .= $ch;
                if ($ch === $stringChar && $prev !== '\\') {
                    $inString = false;
                }
                continue;
            }

            if ($ch === "'" || $ch === '"') {
                $inString = true;
                $stringChar = $ch;
                $buffer .= $ch;
                continue;
            }

            if ($ch === ';') {
                $statements[] = $buffer;
                $buffer = '';
                continue;
            }

            $buffer .= $ch;
        }

        if (trim($buffer) !== '') {
            $statements[] = $buffer;
        }

        return $statements;
    }

    protected function humanSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        $size = $bytes;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return number_format($size, $i === 0 ? 0 : 2, ',', '.') . ' ' . $units[$i];
    }

    protected function detectSource(string $fullPath): string
    {
        $first = @file_get_contents($fullPath, false, null, 0, 512);
        if ($first && preg_match('/Source\s*:\s*(\w+)/i', $first, $m)) {
            return strtolower($m[1]);
        }
        return 'manual';
    }
}

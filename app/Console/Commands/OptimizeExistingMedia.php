<?php

namespace App\Console\Commands;

use App\Support\DatabaseMedia;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OptimizeExistingMedia extends Command
{
    protected $signature = 'media:optimize-existing
        {--dry-run : Report savings without updating records}
        {--table= : Optimize one supported table only}
        {--after-id=0 : Process records with IDs greater than this value}
        {--limit=0 : Stop after inspecting this many records; zero means no limit}
        {--max-source-mb=20 : Skip unusually large stored values to protect memory}';

    protected $description = 'Compress existing database-backed images to optimized WebP';

    private const TABLES = [
        'new_arrivals',
        'library_updates',
        'ebook_programs',
        'thesis_programs',
        'periodical_programs',
        'donated_books',
        'open_access_resources',
        'galleries',
        'gallery_images',
    ];

    public function handle(): int
    {
        $requestedTable = trim((string) $this->option('table'));
        if ($requestedTable !== '' && !in_array($requestedTable, self::TABLES, true)) {
            $this->error('Unsupported table. Allowed: '.implode(', ', self::TABLES));

            return self::INVALID;
        }

        $tables = $requestedTable !== '' ? [$requestedTable] : self::TABLES;
        $maxBytes = max(1, (int) $this->option('max-source-mb')) * 1024 * 1024;
        $afterId = max(0, (int) $this->option('after-id'));
        $limit = max(0, (int) $this->option('limit'));
        $inspected = 0;
        $dryRun = (bool) $this->option('dry-run');
        $totals = ['optimized' => 0, 'skipped' => 0, 'before' => 0, 'after' => 0];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'image')) {
                continue;
            }

            $this->newLine();
            $this->components->info(Str::headline($table));

            DB::table($table)
                ->select(['id', 'image'])
                ->whereNotNull('image')
                ->where('image', '<>', '')
                ->where('id', '>', $afterId)
                ->orderBy('id')
                ->chunkById(10, function ($rows) use ($table, $maxBytes, $dryRun, $limit, &$inspected, &$totals) {
                    foreach ($rows as $row) {
                        if ($limit > 0 && $inspected >= $limit) {
                            return false;
                        }

                        $inspected++;
                        $value = (string) $row->image;
                        $before = strlen($value);

                        if ($before > $maxBytes || Str::startsWith(trim($value), ['http://', 'https://'])) {
                            $totals['skipped']++;
                            continue;
                        }

                        $optimized = DatabaseMedia::optimizeStoredValue($value);
                        if ($optimized === null || strlen($optimized) >= $before) {
                            $totals['skipped']++;
                            unset($value, $optimized);
                            continue;
                        }

                        $after = strlen($optimized);
                        if (!$dryRun) {
                            DB::table($table)->where('id', $row->id)->update([
                                'image' => $optimized,
                                'updated_at' => now(),
                            ]);
                        }

                        $totals['optimized']++;
                        $totals['before'] += $before;
                        $totals['after'] += $after;
                        $this->line(sprintf(
                            '%s #%s: %s -> %s%s',
                            $table,
                            $row->id,
                            $this->formatBytes($before),
                            $this->formatBytes($after),
                            $dryRun ? ' (dry run)' : ''
                        ));
                        unset($value, $optimized);
                    }
                });
        }

        $saved = max(0, $totals['before'] - $totals['after']);
        $this->newLine();
        $this->table(
            ['Mode', 'Optimized', 'Skipped', 'Before', 'After', 'Saved'],
            [[
                $dryRun ? 'Dry run' : 'Updated',
                $totals['optimized'],
                $totals['skipped'],
                $this->formatBytes($totals['before']),
                $this->formatBytes($totals['after']),
                $this->formatBytes($saved),
            ]]
        );

        return self::SUCCESS;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes.' B';
        }

        if ($bytes < 1024 * 1024) {
            return number_format($bytes / 1024, 1).' KB';
        }

        return number_format($bytes / (1024 * 1024), 1).' MB';
    }
}

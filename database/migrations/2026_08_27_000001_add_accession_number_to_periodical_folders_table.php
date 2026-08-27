<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('periodical_folders', 'accession_number')) {
            Schema::table('periodical_folders', function (Blueprint $table) {
                $table->string('accession_number', 100)->nullable()->after('category');
            });
        }

        if (Schema::hasTable('periodical_folders') && Schema::hasColumn('periodical_folders', 'accession_number')) {
            $journalFolders = DB::table('periodical_folders')
                ->where('category', 'journal_newspaper')
                ->orderBy('id')
                ->get(['id', 'accession_number']);
            $existingAccessionNumbers = DB::table('periodical_folders')
                ->whereNotNull('accession_number')
                ->pluck('accession_number')
                ->map(fn ($value) => strtoupper(trim((string) $value)))
                ->all();

            $counter = 1;

            foreach ($journalFolders as $folder) {
                if (filled($folder->accession_number)) {
                    continue;
                }

                do {
                    $candidate = sprintf('JRN-%04d', $counter++);
                } while (in_array($candidate, $existingAccessionNumbers, true));

                DB::table('periodical_folders')
                    ->where('id', $folder->id)
                    ->update([
                        'accession_number' => $candidate,
                    ]);

                $existingAccessionNumbers[] = $candidate;
            }

            Schema::table('periodical_folders', function (Blueprint $table) {
                $table->unique('accession_number');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('periodical_folders') && Schema::hasColumn('periodical_folders', 'accession_number')) {
            Schema::table('periodical_folders', function (Blueprint $table) {
                $table->dropUnique(['accession_number']);
                $table->dropColumn('accession_number');
            });
        }
    }
};

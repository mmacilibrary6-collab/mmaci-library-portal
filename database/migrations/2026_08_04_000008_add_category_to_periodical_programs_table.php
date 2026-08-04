<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('periodical_programs')) {
            return;
        }

        Schema::table('periodical_programs', function (Blueprint $table): void {
            if (! Schema::hasColumn('periodical_programs', 'category')) {
                $table->string('category')->nullable()->after('id');
            }
        });

        DB::table('periodical_programs')
            ->whereNull('category')
            ->update([
                'category' => DB::raw("
                    CASE
                    WHEN LOWER(title) LIKE '%journal%' OR LOWER(title) LIKE '%newspaper%' THEN 'journal_newspaper'
                    WHEN LOWER(title) LIKE '%magazine%' THEN 'magazine'
                    ELSE 'journal_newspaper'
                END
            "),
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('periodical_programs')) {
            return;
        }

        Schema::table('periodical_programs', function (Blueprint $table): void {
            if (Schema::hasColumn('periodical_programs', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};

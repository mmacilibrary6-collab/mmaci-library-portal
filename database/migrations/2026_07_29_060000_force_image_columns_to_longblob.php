<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['ebook_programs', 'galleries', 'gallery_images', 'open_access_resources', 'calendar_events'] as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'image')) {
                DB::statement("ALTER TABLE `{$tableName}` MODIFY `image` LONGBLOB NULL");
            }
        }
    }

    public function down(): void
    {
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('thesis_programs') &&
            Schema::hasColumn('thesis_programs', 'image')
        ) {
            DB::statement("ALTER TABLE `thesis_programs` MODIFY `image` LONGBLOB NULL");
        }
    }

    public function down(): void
    {
    }
};

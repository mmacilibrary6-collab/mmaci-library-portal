<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('new_arrivals') &&
            Schema::hasColumn('new_arrivals', 'image')
        ) {
            DB::statement(
                "ALTER TABLE `new_arrivals` MODIFY `image` LONGBLOB NULL"
            );
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('new_arrivals') &&
            Schema::hasColumn('new_arrivals', 'image')
        ) {
            DB::statement(
                "ALTER TABLE `new_arrivals` MODIFY `image` LONGTEXT NULL"
            );
        }
    }
};

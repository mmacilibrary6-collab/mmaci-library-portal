<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('donated_books') &&
            Schema::hasColumn('donated_books', 'image')
        ) {
            DB::statement("ALTER TABLE `donated_books` MODIFY `image` LONGBLOB NULL");
        }
    }

    public function down(): void
    {
    }
};

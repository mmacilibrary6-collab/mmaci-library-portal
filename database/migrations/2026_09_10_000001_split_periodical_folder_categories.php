<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('periodical_folders')
            ->where('category', 'journal_newspaper')
            ->update(['category' => 'journal']);
    }

    public function down(): void
    {
        DB::table('periodical_folders')
            ->where('category', 'journal')
            ->update(['category' => 'journal_newspaper']);
    }
};

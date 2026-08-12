<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('periodical_folders') && Schema::hasColumn('periodical_folders', 'sort_order')) {
            Schema::table('periodical_folders', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('periodical_folders') && ! Schema::hasColumn('periodical_folders', 'sort_order')) {
            Schema::table('periodical_folders', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->after('folder_link');
            });
        }
    }
};

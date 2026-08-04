<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('periodical_folders', function (Blueprint $table) {
            $table->string('category', 50)->default('journal_newspaper')->after('periodical_program_id');
        });
    }

    public function down(): void
    {
        Schema::table('periodical_folders', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};

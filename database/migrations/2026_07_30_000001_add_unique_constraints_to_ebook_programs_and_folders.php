<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ebook_programs', function (Blueprint $table): void {
            $table->unique('title', 'ebook_programs_title_unique');
        });

        Schema::table('ebook_folders', function (Blueprint $table): void {
            $table->unique(
                ['ebook_program_id', 'title'],
                'ebook_folders_program_title_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebook_programs', function (Blueprint $table): void {
            $table->dropUnique('ebook_programs_title_unique');
        });

        Schema::table('ebook_folders', function (Blueprint $table): void {
            $table->dropUnique('ebook_folders_program_title_unique');
        });
    }
};

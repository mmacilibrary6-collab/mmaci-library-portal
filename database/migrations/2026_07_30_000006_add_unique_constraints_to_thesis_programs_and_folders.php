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
        Schema::table('thesis_programs', function (Blueprint $table): void {
            $table->unique('title', 'thesis_programs_title_unique');
        });

        Schema::table('thesis_folders', function (Blueprint $table): void {
            $table->unique(
                ['thesis_program_id', 'title'],
                'thesis_folders_program_title_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thesis_programs', function (Blueprint $table): void {
            $table->dropUnique('thesis_programs_title_unique');
        });

        Schema::table('thesis_folders', function (Blueprint $table): void {
            $table->dropUnique('thesis_folders_program_title_unique');
        });
    }
};

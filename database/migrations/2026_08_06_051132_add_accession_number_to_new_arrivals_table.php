<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('new_arrivals', function (Blueprint $table) {
            $table
                ->string('accession_number', 100)
                ->nullable()
                ->unique()
                ->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('new_arrivals', function (Blueprint $table) {
            $table->dropUnique(
                'new_arrivals_accession_number_unique'
            );

            $table->dropColumn('accession_number');
        });
    }
};
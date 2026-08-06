<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('new_arrivals', function (Blueprint $table) {
            $table->dropColumn('resource_type');
        });
    }

    public function down(): void
    {
        Schema::table('new_arrivals', function (Blueprint $table) {
            $table
                ->string('resource_type')
                ->default('printed');
        });
    }
};
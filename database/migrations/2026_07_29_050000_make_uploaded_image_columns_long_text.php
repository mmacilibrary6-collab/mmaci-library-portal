<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['galleries', 'gallery_images', 'open_access_resources', 'calendar_events'] as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'image')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                    $table->longText('image')->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
    }
};

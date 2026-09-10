<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reference_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('website_url', 2048);
            $table->binary('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE reference_resources MODIFY image LONGBLOB NULL');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_resources');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('open_access_resources', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->string('website_url', 2048);

            $table->string('image')
                ->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('open_access_resources');
    }
};
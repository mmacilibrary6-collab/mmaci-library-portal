<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodical_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periodical_program_id')->nullable()->constrained('periodical_programs')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('folder_link');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodical_folders');
    }
};

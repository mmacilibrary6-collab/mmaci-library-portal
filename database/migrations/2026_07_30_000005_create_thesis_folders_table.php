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
        Schema::create('thesis_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thesis_program_id')->nullable()->constrained('thesis_programs')->nullOnDelete();
            $table->string('title')->default('');
            $table->text('description')->nullable();
            $table->text('drive_link')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_folders');
    }
};

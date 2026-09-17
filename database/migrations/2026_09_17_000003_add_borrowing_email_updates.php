<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->string('accession_number', 100)->nullable()->change();
        });

        Schema::create('borrowing_email_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained()->cascadeOnDelete();
            $table->string('event', 30);
            $table->string('event_key', 60);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedInteger('attempts')->default(0);
            $table->timestamps();
            $table->unique(['borrowing_id', 'event_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowing_email_updates');
        // Unassigned requests must remain valid when rolling back email support.
    }
};

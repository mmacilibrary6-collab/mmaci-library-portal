<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_number', 100)->unique();
            $table->string('contact_number', 50)->nullable();
            $table->string('department', 150);
            $table->string('semester', 100)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained()->cascadeOnDelete();
            $table->foreignId('new_arrival_id')->nullable()->constrained('new_arrivals')->nullOnDelete();
            $table->string('accession_number', 100);
            $table->text('bibliographical_description');
            $table->date('date_borrowed')->nullable();
            $table->date('due_date')->nullable();
            $table->date('date_returned')->nullable();
            $table->string('status', 30)->default('pending');
            $table->string('received_by')->nullable();
            $table->string('returned_by')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('returned_processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['accession_number', 'status']);
            $table->index(['date_borrowed', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
        Schema::dropIfExists('borrowers');
    }
};

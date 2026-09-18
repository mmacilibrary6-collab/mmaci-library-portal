<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            $table->enum('borrower_type', ['student', 'faculty', 'other'])->nullable()->change();
            $table->string('borrower_type_other', 80)->nullable();
        });
    }

    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::table('borrowers')->where('borrower_type', 'other')->exists()) {
            throw new \RuntimeException('Reclassify Other borrowers before rolling back custom borrower types.');
        }
        Schema::table('borrowers', fn (Blueprint $table) => $table->enum('borrower_type', ['student', 'faculty'])->nullable()->change());
        Schema::table('borrowers', fn (Blueprint $table) => $table->dropColumn('borrower_type_other'));
    }
};

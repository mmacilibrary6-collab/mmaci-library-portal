<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->unsignedTinyInteger('renewal_count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', fn (Blueprint $table) => $table->dropColumn('renewal_count'));
    }
};

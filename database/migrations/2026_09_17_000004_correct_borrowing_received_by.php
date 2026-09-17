<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('borrowings')
            ->whereIn('status', ['borrowed', 'overdue', 'returned'])
            ->whereExists(function ($query) {
                $query->selectRaw('1')->from('borrowers')->whereColumn('borrowers.id', 'borrowings.borrower_id');
            })
            ->update(['received_by' => DB::raw('(SELECT name FROM borrowers WHERE borrowers.id = borrowings.borrower_id)')]);
    }

    public function down(): void
    {
        // Incorrect staff names cannot be reconstructed safely.
    }
};

<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::updateOrCreate(
            ['email' => 'mmacilibrary6@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('mmacilrc2026.'),
                'email_verified_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'mmacilibrary6@gmail.com')->delete();
    }
};

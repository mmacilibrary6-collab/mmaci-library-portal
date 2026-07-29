<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Seed the super-admin account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'mmacilibrary6@gmail.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => 'mmacilrc2026.',
                'email_verified_at' => now(),
            ]
        );
    }
}

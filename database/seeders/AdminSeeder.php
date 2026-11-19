<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@lacuna.test'],
            [
                'name' => 'Lacuna Administrator',
                'username' => 'admin',
                'password_hash' => 'password123',
                'role' => 'ADMIN',
                'account_status' => 'ACTIVE',
            ]
        );
    }
}

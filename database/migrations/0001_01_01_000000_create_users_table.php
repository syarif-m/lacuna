
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Informasi pengguna
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();

            // Password yang telah di-hash
            $table->string('password_hash');

            // Role dan status akun
            $table->enum('role', ['MEMBER', 'ADMIN'])
                ->default('MEMBER');

            $table->enum('account_status', ['ACTIVE', 'SUSPENDED'])
                ->default('ACTIVE');

            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

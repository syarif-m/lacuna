<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theory_votes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('theory_id')
                  ->constrained('theories')
                  ->cascadeOnDelete();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->enum('choice', [
                'AGREE',
                'DISAGREE'
            ]);

            $table->timestamps();

            $table->unique(['theory_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theory_votes');
    }
};
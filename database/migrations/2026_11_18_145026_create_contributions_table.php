<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('submitted_by')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->enum('contribution_type', [
                'CASE_CREATE',
                'THEORY_CREATE',
                'EXPLANATION_CREATE',
                'INFORMATION_CONTRIBUTION'
            ]);

            $table->foreignId('target_case_id')
                  ->nullable()
                  ->constrained('cases')
                  ->restrictOnDelete();

            $table->enum('current_status', [
                'PENDING',
                'APPROVED',
                'REJECTED',
                'WITHDRAWN',
                'INTEGRATED',
                'NOT_USED'
            ])->default('PENDING');

            $table->timestamp('submitted_at')->useCurrent();

            $table->timestamp('withdrawn_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
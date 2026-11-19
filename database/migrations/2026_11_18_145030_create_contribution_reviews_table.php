<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contribution_id')
                  ->constrained('contributions')
                  ->cascadeOnDelete();

            $table->foreignId('reviewer_id')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->enum('decision', [
                'APPROVED',
                'REJECTED',
                'INTEGRATED',
                'NOT_USED'
            ]);

            $table->enum('editorial_action', [
                'CREATE',
                'INTEGRATE',
                'REPLACE'
            ])->nullable();

            $table->foreignId('resulting_explanation_id')
                  ->nullable()
                  ->constrained('explanations')
                  ->nullOnDelete();

            $table->text('review_note')->nullable();

            $table->json('verification_checklist_json')->nullable();

            $table->timestamp('reviewed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_reviews');
    }
};
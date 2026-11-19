<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('actor_user_id')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->string('action_type');

            $table->string('target_type');
            $table->unsignedBigInteger('target_id');

            $table->text('reason')->nullable();
            $table->json('details_json')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index('action_type');
            $table->index(['target_type', 'target_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
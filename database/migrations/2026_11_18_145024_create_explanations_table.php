<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('explanations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('case_id')
                  ->constrained('cases')
                  ->cascadeOnDelete();

            $table->foreignId('curated_by_admin_id')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->string('title');
            $table->longText('body');

            $table->enum('publication_status', [
                'ACTIVE',
                'SUPERSEDED'
            ])->default('ACTIVE');

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('explanations');
    }
};
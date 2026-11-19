<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_sources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contribution_id')
                  ->constrained('contributions')
                  ->cascadeOnDelete();

            $table->foreignId('source_id')
                  ->constrained('sources')
                  ->restrictOnDelete();

            $table->enum('section_type', [
                'CASE_OVERVIEW',
                'THEORY',
                'EXPLANATION',
                'INFORMATION_OVERVIEW'
            ]);

            $table->text('relevance_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_sources');
    }
};
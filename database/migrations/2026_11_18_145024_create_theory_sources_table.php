<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theory_sources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('theory_id')
                  ->constrained('theories')
                  ->cascadeOnDelete();

            $table->foreignId('source_id')
                  ->constrained('sources')
                  ->restrictOnDelete();

            $table->text('relevance_note')->nullable();

            $table->unique(['theory_id', 'source_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theory_sources');
    }
};
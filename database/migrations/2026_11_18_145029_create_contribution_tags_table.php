<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_tags', function (Blueprint $table) {
            $table->foreignId('contribution_id')
                  ->constrained('contributions')
                  ->cascadeOnDelete();

            $table->foreignId('tag_id')
                  ->constrained('tags')
                  ->restrictOnDelete();

            $table->primary(['contribution_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_tags');
    }
};
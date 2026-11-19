<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contribution_id')
                  ->constrained('contributions')
                  ->cascadeOnDelete();

            $table->foreignId('source_id')
                  ->nullable()
                  ->constrained('sources')
                  ->nullOnDelete();

            $table->string('temporary_image_path');
            $table->string('alt_text');
            $table->string('caption')->nullable();
            $table->text('context_description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_images');
    }
};
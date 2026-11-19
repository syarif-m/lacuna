<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('case_id')
                  ->constrained('cases')
                  ->cascadeOnDelete();

            $table->foreignId('source_id')
                  ->nullable()
                  ->constrained('sources')
                  ->nullOnDelete();

            $table->string('image_path');
            $table->string('alt_text');
            $table->string('caption')->nullable();
            $table->text('context_description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_images');
    }
};
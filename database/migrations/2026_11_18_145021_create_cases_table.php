<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->foreignId('verification_status_tag_id')
                  ->constrained('tags')
                  ->restrictOnDelete();

            $table->foreignId('explanation_status_tag_id')
                  ->constrained('tags')
                  ->restrictOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description');

            $table->text('central_mystery');
            $table->longText('overview_content')->nullable();

            $table->enum('publication_status', [
                'DRAFT',
                'PUBLISHED',
                'UNPUBLISHED',
                'ARCHIVED'
            ])->default('DRAFT');

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
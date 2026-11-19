<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('case_id')
                  ->constrained('cases')
                  ->cascadeOnDelete();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary');
            $table->longText('body');

            $table->enum('publication_status', [
                'PUBLISHED',
                'UNPUBLISHED'
            ])->default('PUBLISHED');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theories');
    }
};
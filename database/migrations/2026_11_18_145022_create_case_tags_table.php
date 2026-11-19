<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_tags', function (Blueprint $table) {
            $table->foreignId('case_id')
                  ->constrained('cases')
                  ->cascadeOnDelete();

            $table->foreignId('tag_id')
                  ->constrained('tags')
                  ->cascadeOnDelete();

            $table->primary(['case_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_tags');
    }
};
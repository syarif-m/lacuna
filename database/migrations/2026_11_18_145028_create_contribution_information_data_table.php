<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_information_data', function (Blueprint $table) {
            $table->foreignId('contribution_id')
                  ->primary()
                  ->constrained('contributions')
                  ->cascadeOnDelete();

            $table->string('subject');
            $table->longText('information_content');
            $table->text('context_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_information_data');
    }
};
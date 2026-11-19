<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_theory_data', function (Blueprint $table) {
            $table->foreignId('contribution_id')
                  ->primary()
                  ->constrained('contributions')
                  ->cascadeOnDelete();

            $table->string('proposed_title');
            $table->string('proposed_summary');
            $table->longText('proposed_body');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_theory_data');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();

            $table->string('source_type');

            $table->enum('traceability_level', [
                'DIRECT_LINK',
                'BIBLIOGRAPHIC_LOCATOR',
                'SOURCE_LEAD'
            ]);

            $table->string('title');
            $table->string('author')->nullable();
            $table->string('publisher_or_platform')->nullable();

            $table->date('published_at')->nullable();

            $table->text('url')->nullable();

            $table->text('description')->nullable();

                        $table->timestamp('accessed_at')->nullable();

            $table->timestamps();

            $table->index('source_type');
            $table->index('traceability_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
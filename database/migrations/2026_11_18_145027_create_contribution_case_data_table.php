
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribution_case_data', function (Blueprint $table) {
            // Primary key sekaligus foreign key ke contributions
            $table->unsignedBigInteger('contribution_id')->primary();

            // Data pengajuan Case
            $table->string('proposed_title', 255);
            $table->text('proposed_summary');
            $table->text('central_mystery');
            $table->longText('overview_content')->nullable();

            // Status yang disarankan oleh Member
            $table->unsignedBigInteger('suggested_verification_status_tag_id');
            $table->unsignedBigInteger('suggested_explanation_status_tag_id');

            // Foreign key: contributions
            $table->foreign('contribution_id', 'ccdata_contribution_fk')
                ->references('id')
                ->on('contributions')
                ->cascadeOnDelete();

            // Foreign key: verification status tag
            $table->foreign(
                'suggested_verification_status_tag_id',
                'ccdata_ver_status_fk'
            )
                ->references('id')
                ->on('tags')
                ->restrictOnDelete();

            // Foreign key: explanation status tag
            $table->foreign(
                'suggested_explanation_status_tag_id',
                'ccdata_exp_status_fk'
            )
                ->references('id')
                ->on('tags')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribution_case_data');
    }
};

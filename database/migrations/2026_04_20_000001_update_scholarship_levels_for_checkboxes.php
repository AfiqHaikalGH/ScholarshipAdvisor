<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scholarship_levels', function (Blueprint $table) {
            // Must drop FK first before we can drop the unique index that references education_level
            $table->dropForeign(['scholarship_id']);

            // Drop old unique constraint on (scholarship_id, education_level)
            $table->dropUnique(['scholarship_id', 'education_level']);

            // Drop old single-value columns
            $table->dropColumn(['education_level', 'min_cgpa']);

            // Re-add the foreign key
            $table->foreign('scholarship_id')->references('id')->on('scholarships')->onDelete('cascade');

            // Add new JSON column to hold multiple levels per block
            $table->json('education_levels')->nullable()->after('scholarship_id');

            // Add explicit CGPA columns for all qualification levels
            $table->decimal('min_diploma_cgpa', 3, 2)->nullable()->after('education_levels');
            $table->decimal('min_foundation_cgpa', 3, 2)->nullable()->after('min_diploma_cgpa');
            $table->decimal('min_stpm_cgpa', 3, 2)->nullable()->after('min_foundation_cgpa');
            $table->decimal('min_bachelor_cgpa', 3, 2)->nullable()->after('min_stpm_cgpa');
            $table->decimal('min_master_cgpa', 3, 2)->nullable()->after('min_bachelor_cgpa');

            // Add MUET band field
            $table->string('muet_band', 10)->nullable()->after('min_master_cgpa');
        });
    }

    public function down(): void
    {
        Schema::table('scholarship_levels', function (Blueprint $table) {
            $table->dropForeign(['scholarship_id']);

            $table->dropColumn([
                'education_levels',
                'min_diploma_cgpa',
                'min_foundation_cgpa',
                'min_stpm_cgpa',
                'min_bachelor_cgpa',
                'min_master_cgpa',
                'muet_band',
            ]);

            // Restore original columns
            $table->string('education_level')->after('scholarship_id');
            $table->decimal('min_cgpa', 3, 2)->nullable()->after('education_level');

            $table->foreign('scholarship_id')->references('id')->on('scholarships')->onDelete('cascade');
            $table->unique(['scholarship_id', 'education_level']);
        });
    }
};

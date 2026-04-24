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
        // First drop the scholarship_eligibilities table to avoid foreign key constraints errors if any (or we drop it after, but actually it references scholarships, so dropping it is fine).
        Schema::dropIfExists('scholarship_eligibilities');

        Schema::table('scholarships', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['program_name', 'type']);

            // Combined Eligibility Fields
            $table->decimal('min_stpm_cgpa', 3, 2)->nullable();
            $table->decimal('min_matriculation_cgpa', 3, 2)->nullable();
            $table->json('spm_subjects')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('place_of_study')->nullable();
            $table->string('citizenship')->nullable();
            $table->integer('age_limit')->nullable();
            $table->string('income_category')->nullable();
            $table->string('health_requirement')->nullable();
            $table->boolean('has_other_scholarship_restriction')->default(false);
            $table->boolean('blacklist_status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('program_name')->nullable();
            $table->string('type')->nullable();
            
            $table->dropColumn([
                'min_stpm_cgpa',
                'min_matriculation_cgpa',
                'spm_subjects',
                'field_of_study',
                'place_of_study',
                'citizenship',
                'age_limit',
                'income_category',
                'health_requirement',
                'has_other_scholarship_restriction',
                'blacklist_status'
            ]);
        });

        Schema::create('scholarship_eligibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->decimal('min_cgpa', 3, 2)->nullable();
            $table->string('min_spm_result')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('citizenship')->nullable();
            $table->integer('age_limit')->nullable();
            $table->string('income_category')->nullable();
            $table->string('health_requirement')->nullable();
            $table->boolean('has_other_scholarship_restriction')->default(false);
            $table->boolean('blacklist_status')->default(false);
            $table->timestamps();
        });
    }
};

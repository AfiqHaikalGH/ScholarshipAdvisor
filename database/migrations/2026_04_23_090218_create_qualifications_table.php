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
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal & Background
            $table->string('father_birthstate')->nullable();
            $table->string('mother_birthstate')->nullable();
            $table->integer('years_resident')->nullable();
            $table->string('current_state')->nullable();
            $table->decimal('household_income', 10, 2)->nullable();
            $table->string('income_category')->nullable(); // e.g. B40, M40, T20
            
            // Current Study Status
            $table->string('education_level')->nullable();
            $table->string('enrollment_status')->nullable(); // full-time, part-time
            $table->string('field_of_study')->nullable();
            $table->integer('year_of_bachelor_study')->nullable();
            $table->boolean('research_proposal')->default(false);

            // Results & Grades
            $table->string('spm_result')->nullable(); // e.g. 5A, 5A+
            $table->string('bahasa_melayu')->nullable();
            $table->string('english')->nullable();
            $table->string('mathematics')->nullable();
            $table->string('stpm_result')->nullable(); // e.g. 3A, 4C
            $table->integer('muet_band')->nullable();

            // CGPAs
            $table->decimal('diploma_cgpa', 3, 2)->nullable();
            $table->decimal('stpm_cgpa', 3, 2)->nullable();
            $table->decimal('foundation_cgpa', 3, 2)->nullable();
            $table->decimal('bachelor_cgpa', 3, 2)->nullable();
            $table->decimal('master_cgpa', 3, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};

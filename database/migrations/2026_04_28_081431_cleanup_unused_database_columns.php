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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ic_num']);
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn([
                'programme_levels',
                'min_stpm_cgpa',
                'min_matriculation_cgpa',
                'min_diploma_cgpa',
                'min_spm_result',
                'cefr',
                'spm_subjects',
                'field_of_study',
                'place_of_study',
                'age_limit'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ic_num')->nullable();
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->json('programme_levels')->nullable();
            $table->decimal('min_stpm_cgpa', 3, 2)->nullable();
            $table->decimal('min_matriculation_cgpa', 3, 2)->nullable();
            $table->decimal('min_diploma_cgpa', 3, 2)->nullable();
            $table->string('min_spm_result')->nullable();
            $table->string('cefr')->nullable();
            $table->json('spm_subjects')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('place_of_study')->nullable();
            $table->integer('age_limit')->nullable();
        });
    }
};

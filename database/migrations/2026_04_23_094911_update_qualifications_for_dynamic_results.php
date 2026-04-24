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
        Schema::table('qualifications', function (Blueprint $table) {
            $table->dropColumn(['spm_result', 'bahasa_melayu', 'english', 'mathematics', 'stpm_result']);
            $table->json('spm_results')->nullable();
            $table->json('stpm_results')->nullable();
            $table->decimal('current_bachelor_cgpa', 4, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->string('spm_result')->nullable();
            $table->string('bahasa_melayu')->nullable();
            $table->string('english')->nullable();
            $table->string('mathematics')->nullable();
            $table->string('stpm_result')->nullable();
            $table->dropColumn(['spm_results', 'stpm_results', 'current_bachelor_cgpa']);
        });
    }
};

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
        Schema::create('scholarship_eligibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_id')
              ->constrained()
              ->onDelete('cascade');

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_eligibilities');
    }
};

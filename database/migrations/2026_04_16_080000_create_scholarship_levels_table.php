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
        Schema::create('scholarship_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->string('education_level');
            $table->decimal('min_cgpa', 3, 2)->nullable();
            $table->integer('age_limit')->nullable();
            $table->longText('additional_requirements')->nullable();
            $table->timestamps();

            $table->unique(['scholarship_id', 'education_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_levels');
    }
};

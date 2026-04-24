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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider')->nullable();
            $table->string('program_name')->nullable();
            $table->string('type')->nullable();
            $table->string('level')->nullable();

            $table->text('description')->nullable();

            $table->decimal('amount_per_year', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->integer('duration')->nullable();
            $table->string('coverage')->nullable();

            $table->date('application_start_date')->nullable();
            $table->date('application_end_date')->nullable();
            $table->string('application_status')->nullable();

            // Bond (display only)
            $table->boolean('bond_required')->default(false);
            $table->integer('bond_duration')->nullable();
            $table->string('bond_organization')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};

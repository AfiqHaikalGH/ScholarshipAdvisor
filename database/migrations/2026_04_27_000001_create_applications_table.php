<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('scholarship_name');
            $table->string('apply_url');
            $table->enum('acceptance_status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'scholarship_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

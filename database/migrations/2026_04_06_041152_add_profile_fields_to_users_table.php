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
            $table->string('address')->nullable();
            $table->string('ic_num')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable();
            $table->string('birth_state')->nullable();
            $table->string('phone_num')->nullable();
            $table->date('dob')->nullable();
            $table->string('place_of_study')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
            'address',
            'ic_num',
            'gender',
            'marital_status',
            'nationality',
            'birth_state',
            'phone_num',
            'dob',
            'place_of_study'
        ]);
        });
    }
};

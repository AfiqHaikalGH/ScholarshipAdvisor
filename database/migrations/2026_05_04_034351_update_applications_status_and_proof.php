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
        Schema::table('applications', function (Blueprint $table) {
            $table->enum('status', ['Not Apply', 'Applied', 'Approved', 'Rejected'])->default('Not Apply')->after('apply_url');
            $table->string('proof_path')->nullable()->after('status');
        });

        // Migrate existing data
        DB::table('applications')->where('acceptance_status', 'Pending')->update(['status' => 'Not Apply']);
        DB::table('applications')->where('acceptance_status', 'Accepted')->update(['status' => 'Approved']);
        DB::table('applications')->where('acceptance_status', 'Rejected')->update(['status' => 'Rejected']);

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('acceptance_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->enum('acceptance_status', ['Pending', 'Accepted', 'Rejected'])->default('Pending')->after('apply_url');
        });

        DB::table('applications')->where('status', 'Not Apply')->update(['acceptance_status' => 'Pending']);
        DB::table('applications')->where('status', 'Applied')->update(['acceptance_status' => 'Pending']);
        DB::table('applications')->where('status', 'Approved')->update(['acceptance_status' => 'Accepted']);
        DB::table('applications')->where('status', 'Rejected')->update(['acceptance_status' => 'Rejected']);

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['status', 'proof_path']);
        });
    }
};

<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Scholarship;
use App\Models\ScholarshipLevel;
use Illuminate\Support\Facades\DB;

DB::transaction(function() {
    $scholarships = Scholarship::with('scholarshipLevels')->get();
    $deletedCount = 0;

    foreach ($scholarships as $scholarship) {
        $activeLevels = [];
        
        foreach ($scholarship->scholarshipLevels as $level) {
            // Check if this block is empty
            $isEmpty = (
                ($level->min_diploma_cgpa ?? 0) <= 0 &&
                ($level->min_foundation_cgpa ?? 0) <= 0 &&
                ($level->min_stpm_cgpa ?? 0) <= 0 &&
                ($level->min_bachelor_cgpa ?? 0) <= 0 &&
                ($level->min_master_cgpa ?? 0) <= 0 &&
                empty($level->muet_band) &&
                empty($level->age_limit) &&
                (empty($level->additional_requirements) || $level->additional_requirements === '[]' || $level->additional_requirements === '{}')
            );

            if ($isEmpty) {
                $level->delete();
                $deletedCount++;
            } else {
                // Collect labels from active blocks
                $labels = is_array($level->education_levels) ? $level->education_levels : json_decode($level->education_levels, true);
                if (is_array($labels)) {
                    foreach ($labels as $label) {
                        $activeLevels[] = $label;
                    }
                }
            }
        }

        // Update the scholarship's main level string
        $scholarship->update([
            'level' => implode(', ', array_unique($activeLevels))
        ]);
    }

    echo "Cleanup Complete!" . PHP_EOL;
    echo "Removed $deletedCount empty placeholders." . PHP_EOL;
});

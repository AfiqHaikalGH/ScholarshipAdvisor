<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$scholarships = \App\Models\Scholarship::select('name', 'apply_url')->get();
$recs = \App\Models\Recommendation::select('scholarship_name')->distinct()->get();

echo "Scholarships:\n";
foreach($scholarships as $s) {
    echo "- Name: '{$s->name}', URL: '{$s->apply_url}'\n";
}

echo "\nRecommendations:\n";
foreach($recs as $r) {
    echo "- Name: '{$r->scholarship_name}'\n";
}

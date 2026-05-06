<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Scholarship;

$urls = [
    'Biasiswa Perdana - Biasiswa Kerajaan Negeri Sabah' => 'https://ptps.sabah.gov.my/public-bkns/authentication/register.php',
    'Biasiswa Cemerlang Negeri Sabah (BCNS)' => 'https://ptps.sabah.gov.my/public-bkns/authentication/register.php',
    'Biasiswa Cemerlang Pelajar Luar Bandar (BCPLP)' => 'https://ptps.sabah.gov.my/yayasan-sabah/register',
    'Biasiswa Skim Pelajar Cemerlang Yayasan Terengganu' => 'https://ytpenajaan.terengganu.gov.my/register',
    "Biasiswa Khas Dato' Menteri Besar Selangor" => 'https://edanapendidikan.selangor.gov.my/register',
    'Biasiswa Sarawak Tunku Abdul Rahman (YBSTAR)' => 'https://yayasansarawak.org.my/my/laman-utama/',
    'Pinjaman Boleh Ubah Luar Negara (PBULN)' => 'https://edanapendidikan.selangor.gov.my/login',
    'Khazanah Watan Scholarship Program' => 'https://www.yayasankhazanah.com.my/apply-now',
    'Kijang Undergraduate Scholarship' => 'https://www.bnm.gov.my/careers/scholarships',
    'YSD Undergraduate Excellence Scholarship' => 'https://www.yayasansimedarby.com/scholarship-information',
];

foreach ($urls as $name => $url) {
    Scholarship::where('name', $name)->update(['apply_url' => $url]);
    echo "Updated: $name\n";
}

echo "Backfill complete.\n";

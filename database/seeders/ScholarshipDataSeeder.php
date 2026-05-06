<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scholarship;
use Illuminate\Support\Facades\DB;

class ScholarshipDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function() {
            // Clear existing data to avoid duplicates
            DB::table('scholarship_levels')->delete();
            DB::table('scholarships')->delete();

            $s13 = Scholarship::create(array (
  'name' => 'BIASISWA PERDANA - BIASISWA KERAJAAN NEGERI SABAH',
  'provider' => 'Jabatan Perkhidmatan Awam Negeri Sabah',
  'description' => 'Kerajaan Negeri Sabah mempelawa permohonan Biasiswa untuk mengikuti pengajian di peringkat Diploma, Sarjana Muda dan Sarjana. Syarat utama permohonan ialah pemohon dan ibu bapa hendaklah warganegara Malaysia yang bermastautin di Sabah; sama ada kedua-dua ibu bapa berasal dari Sabah, atau salah seorang daripada ibu bapa berasal dari Sabah.',
  'amount_per_year' => NULL,
  'apply_url' => 'https://ptps.sabah.gov.my/public-bkns/authentication/register.php',
  'level' => 'Diploma, Bachelor, Master',
  'application_start_date' => NULL,
  'application_end_date' => NULL,
  'application_status' => 'Closed',
  'citizenship' => 'Malaysian',
  'income_category' => NULL,
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => true,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s13->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Diploma',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 20,
  'additional_requirements' => '{"place_of_study":"Local Universities","min_spm_result":"5A","spm_subjects":{"Bahasa Melayu":"A","English":"C"}}',
));
            $s13->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => '3.00',
  'min_foundation_cgpa' => '3.00',
  'min_stpm_cgpa' => '3.00',
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 25,
  'additional_requirements' => '{"place_of_study":"Local IPTA","additional_requirements":"Lulus Sijil Tinggi Agama Malaysia (STAM) dengan memperolehi sekurang-kurangnya Jayyid"}',
));
            $s13->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Master',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => '3.50',
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 30,
  'additional_requirements' => '{"place_of_study":"Local IPTA"}',
));

            $s14 = Scholarship::create(array (
  'name' => 'Biasiswa Cemerlang Negeri Sabah (BCNS)',
  'provider' => 'Kumpulan Yayasan Sabah',
  'description' => NULL,
  'amount_per_year' => NULL,
  'apply_url' => 'https://ptps.sabah.gov.my/public-bkns/authentication/register.php',
  'level' => 'Bachelor',
  'application_start_date' => NULL,
  'application_end_date' => '2026-04-06',
  'application_status' => 'Open',
  'citizenship' => 'Malaysian',
  'income_category' => NULL,
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => false,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s14->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 35,
  'additional_requirements' => '{"place_of_study":"Inside and outside country","min_spm_result":"5A+","spm_subjects":{"Bahasa Melayu":"A+"},"additional_requirements":"For SPM 2025"}',
));

            $s15 = Scholarship::create(array (
  'name' => 'Biasiswa Cemerlang Pelajar Luar Bandar (BCPLB)',
  'provider' => 'Kumpulan Yayasan Sabah',
  'description' => 'Kriteria pemohon adalah seperti berikut:
(i) Pemohon, ibu dan bapa warganegara Malaysia yang berasal dari Negeri Sabah; atau 
(ii) Pemohon, ibu dan bapa warganegara Malaysia tetapi salah seorang ibu atau bapa berasal dari Negeri Sabah; atau 
(iii) Pemohon, ibu atau bapa warganegara Malaysia tetapi salah seorang ibu atau bapa mempunyai status Penduduk Tetap di Negeri Sabah. 
 
*Keutamaan diberikan kepada mereka yang berasal dan menetap di Negeri Sabah',
  'amount_per_year' => NULL,
  'apply_url' => 'https://ptps.sabah.gov.my/yayasan-sabah/register',
  'level' => 'Bachelor',
  'application_start_date' => NULL,
  'application_end_date' => '2026-05-06',
  'application_status' => 'Open',
  'citizenship' => 'Malaysian',
  'income_category' => 'B40',
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => false,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s15->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => NULL,
  'additional_requirements' => '{"place_of_study":"Local IPTA","min_spm_result":"5A","spm_subjects":{"Bahasa Melayu":"A"},"additional_requirements":"For SPM2025"}',
));

            $s16 = Scholarship::create(array (
  'name' => 'Biasiswa Skim Pelajar Cemerlang Yayasan Terengganu',
  'provider' => 'Yayasan Terengganu',
  'description' => 'Syarat Umum:
i. Pemohon mestilah terdiri daripada Rakyat Negeri Terengganu di mana salah seorang 
ibu atau bapa pemohon berkenaan lahir di Negeri Terengganu.
ii. Pemohon dan/atau ibu/bapa bukan rakyat Terengganu tetapi bermastautin selama 10 
tahun atau lebih boleh juga memohon dengan menyertakan Sijil Kerakyatan atau surat 
akuan bermastautin. 
iii. Ibu/bapa dan/atau pemohon mestilah mendaftar sebagai pemilih/pengundi di Negeri 
Terengganu.

UJIAN BERTULIS & TEMUDUGA 
Hanya calon-calon yang layak disenarai pendek akan dipanggil menduduki Ujian Bertulis & 
Temuduga yang dikendalikan oleh Yayasan Terengganu.',
  'amount_per_year' => NULL,
  'apply_url' => 'https://ytpenajaan.terengganu.gov.my/register',
  'level' => 'Bachelor',
  'application_start_date' => NULL,
  'application_end_date' => NULL,
  'application_status' => 'Closed',
  'citizenship' => 'Malaysian',
  'income_category' => 'B40',
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => false,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s16->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => '3.75',
  'min_stpm_cgpa' => '3.75',
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => 'Band 3',
  'age_limit' => 25,
  'additional_requirements' => '{"place_of_study":"Local IPTA","min_spm_result":"8B+","spm_subjects":{"Bahasa Melayu":"B+"}}',
));

            $s17 = Scholarship::create(array (
  'name' => 'Biasiswa Khas Dato\' Menteri Besar Selangor',
  'provider' => 'Tabung Kumpulan Wang Biasiswa Negeri Selangor',
  'description' => '1. Pemohon mestilah terdiri daripada Rakyat DYMM Sultan Selangor Darul Ehsan yang memenuhi kriteria seperti berikut:
i. Pemohon dan Ibu Bapa merupakan warganegara Malaysia; dan
ii. Pemohon, Ibu atau Bapa lahir dan menetap di Negeri Selangor; atau
iii. Pemohon telah dan sedang bermastautin lebih sepuluh (10) tahun di Selangor.
2. Mengikuti pengajian secara sepenuh masa.',
  'amount_per_year' => NULL,
  'apply_url' => 'https://edanapendidikan.selangor.gov.my/register',
  'level' => 'Bachelor, Master, PhD',
  'application_start_date' => NULL,
  'application_end_date' => NULL,
  'application_status' => 'Closed',
  'citizenship' => 'Malaysian',
  'income_category' => 'M40',
  'health_requirement' => 'Healthy body',
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => true,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s17->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => '3.75',
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => '3.75',
  'min_master_cgpa' => NULL,
  'muet_band' => 'Band 5',
  'age_limit' => 40,
  'additional_requirements' => '{"place_of_study":"Top 100 universities"}',
));
            $s17->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Master',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => '3.75',
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => '3.75',
  'min_master_cgpa' => NULL,
  'muet_band' => 'Band 5',
  'age_limit' => 40,
  'additional_requirements' => '{"place_of_study":"Top 100 universities","additional_requirements":"Pemohon hendaklah menyertakan salinan \\u2019Research Proposal\\u2019 yang telah diterima oleh Universiti bersama-sama dengan borang permohonan. \\u2019Research Proposal\\u2019 hendaklah menyumbang kepada pembangunan Negeri Selangor bagi calon pascasiswazah."}',
));
            $s17->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'PhD',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => '3.75',
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => '3.75',
  'min_master_cgpa' => '3.75',
  'muet_band' => NULL,
  'age_limit' => 40,
  'additional_requirements' => '{"place_of_study":"Top 100 universities","additional_requirements":"Pemohon hendaklah menyertakan salinan \\u2019Research Proposal\\u2019 yang telah diterima oleh Universiti bersama-sama dengan borang permohonan. \\u2019Research Proposal\\u2019 hendaklah menyumbang kepada pembangunan Negeri Selangor bagi calon pascasiswazah."}',
));

            $s18 = Scholarship::create(array (
  'name' => 'Biasiswa Sarawak Tunku Abdul Rahman (YBSTAR)',
  'provider' => 'Yayasan Sarawak',
  'description' => 'Menyediakan biasiswa kepada pelajar cemerlang yang mengikuti pengajian di mana-mana Institusi Pengajian Tinggi di dalam dan luar negara dengan keutamaan di Institusi Pengajian Tinggi Swasta milik Kerajaan Sarawak.',
  'amount_per_year' => NULL,
  'apply_url' => 'https://yayasansarawak.org.my/my/laman-utama/',
  'level' => 'Bachelor, Master, PhD',
  'application_start_date' => NULL,
  'application_end_date' => NULL,
  'application_status' => 'Closed',
  'citizenship' => 'Malaysian',
  'income_category' => NULL,
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => false,
  'blacklist_status' => false,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s18->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => '3.00',
  'min_stpm_cgpa' => '3.00',
  'min_bachelor_cgpa' => '3.00',
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => NULL,
  'additional_requirements' => '{"place_of_study":"Malaysia","spm_subjects":{"Bahasa Melayu":"C"}}',
));
            $s18->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Master',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => '3.00',
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => NULL,
  'additional_requirements' => '{"place_of_study":"Inside and outside Malaysia","spm_subjects":{"Bahasa Melayu":"C"}}',
));
            $s18->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'PhD',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => '3.00',
  'muet_band' => NULL,
  'age_limit' => NULL,
  'additional_requirements' => '{"place_of_study":"Inside and outside Malaysia","spm_subjects":{"Bahasa Melayu":"C"}}',
));

            $s19 = Scholarship::create(array (
  'name' => 'Pinjaman Boleh Ubah Luar Negara (PBULN)',
  'provider' => 'Tabung Kumpulan Wang Biasiswa Negeri Selangor (TKWBNS)',
  'description' => 'Pelajar adalah dipelawa untuk memohon Pinjaman Boleh Ubah Luar Negara bagi pengajian peringkat Ijazah Sarjana Muda dan Pascasiswazah di Mesir, Jordan dan Maghribi',
  'amount_per_year' => NULL,
  'apply_url' => 'https://edanapendidikan.selangor.gov.my/login',
  'level' => 'Bachelor',
  'application_start_date' => NULL,
  'application_end_date' => NULL,
  'application_status' => 'Closed',
  'citizenship' => 'Malaysian',
  'income_category' => 'B40',
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => true,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s19->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => NULL,
  'additional_requirements' => '{"place_of_study":"Mesir, Jordan, Maghribi","min_spm_result":"5C","spm_subjects":{"Bahasa Melayu":"C"},"additional_requirements":"i.\\tMemiliki Sijil Pelajaran Malaysia (SPM) dengan kepujian dalam mata pelajaran Bahasa Melayu; dan\\r\\n\\r\\nii.\\tTelah mendapat keputusan sekurang-kurangnya JAYYID (GOOD) dalam peperiksaan terkini bagi pengajian peringkat Ijazah Sarjana Muda; atau\\r\\niii. Memperoleh sekurang-kurangnya lima (5) kepujian dalam mana-mana mata pelajaran di peringkat SPM selain mata pelajaran dinyatakan di (i); atau\\r\\niv. Memperoleh sekurang-kurangnya empat (4) Gred C dalam mana-mana mata pelajaran di peringkat STPM; atau\\r\\nv.\\tMemperoleh sekurang-kurangnya lima (5) kelulusan (Jayyid) dalam mana-mana mata pelajaran di peringkat STAM."}',
));

            $s20 = Scholarship::create(array (
  'name' => 'Khazanah Watan Scholarship Programme',
  'provider' => 'Yayasan Khazanah',
  'description' => 'The Khazanah Watan Scholarship is a prestigious award that offers opportunities for talented and high-achieving Malaysians to pursue Undergraduate and Postgraduate studies at selected leading local universities.

The aim of the Khazanah Watan Scholarship Programme is two-fold:-

To train Malaysia\'s brightest talents to transform its GLCs into competitive business locally and internationally.
To encourage individuals with excellent academic credentials to lead and participate in research initiatives that will contribute to the advancement of the universities\' reputation in research and innovation.',
  'amount_per_year' => NULL,
  'apply_url' => 'https://www.yayasankhazanah.com.my/apply-now',
  'level' => 'Bachelor, Master, PhD',
  'application_start_date' => NULL,
  'application_end_date' => NULL,
  'application_status' => 'Closed',
  'citizenship' => 'Malaysian',
  'income_category' => NULL,
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => false,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s20->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => '3.50',
  'min_foundation_cgpa' => '3.50',
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => '3.50',
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 21,
  'additional_requirements' => '{"place_of_study":"Local University","field_of_study":["Engineering","Arts & Design","Sciences"],"additional_requirements":"Obtained admission to pursue studies (conditional offer can be considered) or currently in the first year of a bachelor\\u2019s degree programme at any of the Yayasan Khazanah\\u2019s approved list of universities.\\r\\n\\r\\n3As for STPM"}',
));
            $s20->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Master',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 40,
  'additional_requirements' => '{"additional_requirements":"Obtained admission at Yayasan Khazanah\\u2019s approved universities in Malaysia (conditional offer can be considered). Those who have applied to the universities but have yet to receive admission are also eligible to apply. In the event that no offer of admission from the university is received during our selection process, please be aware that the scholarship offer will become null and void.\\r\\n\\r\\nThe applicant must have at least two years of working experience"}',
));
            $s20->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'PhD',
  ),
  'min_diploma_cgpa' => NULL,
  'min_foundation_cgpa' => NULL,
  'min_stpm_cgpa' => NULL,
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 40,
  'additional_requirements' => '{"additional_requirements":"Obtained admission to pursue studies or currently in the first year of a Doctoral Degree programme at Yayasan Khazanah\\u2019s approved universities in Malaysia (Conditional offer can be considered). Those who have applied to the universities but have yet to receive admission are also eligible to apply. In the event that no offer of admission from the university is received during our selection process, please be aware that the scholarship offer will become null and void.\\r\\n\\r\\nThe applicant must have at least two years of working experience"}',
));

            $s21 = Scholarship::create(array (
  'name' => 'Kijang Undergraduate Scholarship',
  'provider' => 'Bank Negara',
  'description' => NULL,
  'amount_per_year' => NULL,
  'apply_url' => 'https://www.bnm.gov.my/careers/scholarships',
  'level' => 'Bachelor',
  'application_start_date' => '2026-04-17',
  'application_end_date' => '2026-04-26',
  'application_status' => 'Open',
  'citizenship' => 'Malaysian',
  'income_category' => NULL,
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => false,
  'bond_required' => true,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s21->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => '3.50',
  'min_foundation_cgpa' => '3.50',
  'min_stpm_cgpa' => '3.50',
  'min_bachelor_cgpa' => '3.50',
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 22,
  'additional_requirements' => '{"place_of_study":"Local and Overseas","min_spm_result":"5C","spm_subjects":{"Bahasa Melayu":"C","English":"C","Mathematics":"C"},"additional_requirements":"Strong leadership qualities, proven teamwork capabilities, outstanding performance in extra-curricular activities and exceptional interpersonal skills."}',
));

            $s22 = Scholarship::create(array (
  'name' => 'YSD Undergraduate Excellence Scholarship',
  'provider' => 'Yayasan Sime Darby',
  'description' => NULL,
  'amount_per_year' => NULL,
  'apply_url' => 'https://www.yayasansimedarby.com/scholarship-information',
  'level' => 'Bachelor',
  'application_start_date' => NULL,
  'application_end_date' => NULL,
  'application_status' => 'Closed',
  'citizenship' => 'Malaysian',
  'income_category' => 'B40',
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => false,
  'bond_required' => true,
  'bond_duration' => 3,
  'bond_organization' => 'Sime Darby',
));
            $s22->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => '3.30',
  'min_foundation_cgpa' => '3.30',
  'min_stpm_cgpa' => '3.30',
  'min_bachelor_cgpa' => NULL,
  'min_master_cgpa' => NULL,
  'muet_band' => NULL,
  'age_limit' => 25,
  'additional_requirements' => '{"place_of_study":"Local Universities","field_of_study":["Computer Science & IT","Engineering","STEM"],"additional_requirements":"Strong leadership qualities through various leadership positions in school, national and\\/or global competitions and\\/or sporting events.\\r\\nActive participation in community service."}',
));

            $s23 = Scholarship::create(array (
  'name' => 'Scholarship 1',
  'provider' => 'Provider 1',
  'description' => 'Apply',
  'amount_per_year' => NULL,
  'apply_url' => NULL,
  'level' => 'Bachelor',
  'application_start_date' => '2026-05-05',
  'application_end_date' => '2026-12-31',
  'application_status' => 'Open',
  'citizenship' => 'Malaysian',
  'income_category' => NULL,
  'health_requirement' => NULL,
  'has_other_scholarship_restriction' => true,
  'blacklist_status' => true,
  'bond_required' => false,
  'bond_duration' => NULL,
  'bond_organization' => NULL,
));
            $s23->scholarshipLevels()->create(array (
  'education_levels' => 
  array (
    0 => 'Bachelor',
  ),
  'min_diploma_cgpa' => '3.90',
  'min_foundation_cgpa' => '3.67',
  'min_stpm_cgpa' => '3.00',
  'min_bachelor_cgpa' => '3.80',
  'min_master_cgpa' => NULL,
  'muet_band' => 'Band 4',
  'age_limit' => 25,
  'additional_requirements' => '{"place_of_study":"Local University","min_spm_result":"5A","spm_subjects":{"Bahasa Melayu":"A","Sejarah":"A"},"field_of_study":["Computer Science & IT"],"cefr":"C1"}',
));

        });
    }
}

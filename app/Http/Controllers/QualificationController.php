<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Qualification;
use App\Models\Recommendation;
use App\Models\Scholarship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index()
    {
        $qualification = auth()->user()->qualification ?? new Qualification();
        $hasApplied = Application::where('user_id', auth()->id())
            ->where('is_proof_submitted', true)
            ->exists();
        return view('qualifications.index', compact('qualification', 'hasApplied'));
    }

    public function filter(Request $request)
    {
        $data = $request->validate([
            'father_birthstate' => 'nullable|string',
            'mother_birthstate' => 'nullable|string',
            'years_resident' => 'nullable|integer',
            'current_state' => 'nullable|string',
            'household_income' => 'nullable|numeric',
            'income_category' => 'nullable|string',
            'education_level' => 'nullable|string',
            'enrollment_status' => 'nullable|string',
            'field_of_study' => 'nullable|string',
            'year_of_bachelor_study' => 'nullable|integer',
            'current_bachelor_cgpa' => 'nullable|numeric',
            'muet_band' => 'nullable|string',
            'cefr' => 'nullable|string|in:A1,A2,B1,B2,C1,C2',
        ]);

        // Auto-compute income category server-side
        $income = floatval($data['household_income'] ?? 0);
        if ($income > 0) {
            if ($income <= 3401) {
                $data['income_category'] = 'B40';
            } elseif ($income <= 7971) {
                $data['income_category'] = 'M40';
            } else {
                $data['income_category'] = 'T20';
            }
        }

        // Handle dynamic CGPA rows
        $cgpaLevels = $request->input('cgpa_level', []);
        $cgpaValues = $request->input('cgpa_value', []);
        $data['diploma_cgpa'] = null;
        $data['stpm_cgpa'] = null;
        $data['foundation_cgpa'] = null;
        $data['bachelor_cgpa'] = null;
        $data['master_cgpa'] = null;
        foreach ($cgpaLevels as $i => $level) {
            $val = isset($cgpaValues[$i]) && $cgpaValues[$i] !== '' ? floatval($cgpaValues[$i]) : null;
            if (!$level || $val === null)
                continue;
            switch ($level) {
                case 'Diploma':
                    $data['diploma_cgpa'] = $val;
                    break;
                case 'STPM':
                    $data['stpm_cgpa'] = $val;
                    break;
                case 'Foundation/Matriculation':
                    $data['foundation_cgpa'] = $val;
                    break;
                case 'Bachelor':
                    $data['bachelor_cgpa'] = $val;
                    break;
                case 'Master':
                    $data['master_cgpa'] = $val;
                    break;
            }
        }

        $spmNames = $request->input('spm_subject_name', []);
        $spmGrades = $request->input('spm_subject_grade', []);
        $spmResults = [];
        foreach ($spmNames as $index => $name) {
            if (!empty($name) && !empty($spmGrades[$index])) {
                $spmResults[$name] = strtoupper(trim($spmGrades[$index]));
            }
        }
        $data['spm_results'] = $spmResults;

        $stpmNames = $request->input('stpm_subject_name', []);
        $stpmGrades = $request->input('stpm_subject_grade', []);
        $stpmResults = [];
        foreach ($stpmNames as $index => $name) {
            if (!empty($name) && !empty($stpmGrades[$index])) {
                $stpmResults[$name] = strtoupper(trim($stpmGrades[$index]));
            }
        }
        $data['stpm_results'] = $stpmResults;

        $data['research_proposal'] = $request->has('research_proposal');

        $qualification = Qualification::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        // Run recommendation engine and cache results
        $results = $this->runRecommendationEngine($qualification);
        Recommendation::where('user_id', auth()->id())->delete();
        foreach ($results as $rank => $r) {
            Recommendation::create([
                'user_id' => auth()->id(),
                'scholarship_name' => $r['name'],
                'score' => $r['score'],
                'matches' => $r['matches'],
                'missing' => $r['missing'],
                'rank' => $rank + 1,
            ]);
        }

        return redirect()->route('qualifications.recommendations');
    }

    public function recommendations()
    {
        $userId = auth()->id();
        $cached = Recommendation::where('user_id', $userId)->orderBy('rank')->get();
        if ($cached->isEmpty()) {
            return view('qualifications.recommendations', ['recommendations' => null]);
        }

        // Get user's current applications to mark as "Already Applied"
        $applications = \App\Models\Application::where('user_id', $userId)
            ->where('status', 'Applied')
            ->pluck('scholarship_name')
            ->toArray();

        $recommendations = $cached->map(function ($r) use ($applications) {
            $scholarship = Scholarship::where('name', $r->scholarship_name)->first();
            $applyUrl = $scholarship ? $scholarship->apply_url : null;

            return [
                'name' => $r->scholarship_name,
                'score' => $r->score,
                'matches' => $r->matches ?? [],
                'missing' => $r->missing ?? [],
                'apply_url' => $applyUrl,
                'applied' => in_array($r->scholarship_name, $applications),
            ];
        })->toArray();

        return view('qualifications.recommendations', compact('recommendations'));
    }

    // ─── Helper Methods ──────────────────────────────────────────────

    /**
     * Add a criterion label to matches or missing based on the condition.
     */
    private function addCriteria(array &$matches, array &$missing, bool $condition, string $label): void
    {
        if ($condition)
            $matches[] = $label;
        else
            $missing[] = $label;
    }

    /**
     * Convert a MUET band string to a comparable numeric value.
     */
    private function muetNumeric($val): float
    {
        if (!$val)
            return 0;
        $v = trim($val);
        if ($v === '5+')
            return 6;
        return floatval($v);
    }

    /**
     * Convert a CEFR level string to a comparable numeric value.
     */
    private function cefrValue($level): int
    {
        $levels = ['A1' => 1, 'A2' => 2, 'B1' => 3, 'B2' => 4, 'C1' => 5, 'C2' => 6];
        return $levels[strtoupper(trim($level ?? ''))] ?? 0;
    }

    /**
     * Convert a letter grade to a numeric value for comparison.
     */
    private function gradeValue($grade): int
    {
        if (!$grade)
            return 0;
        $grades = ['G' => 1, 'E' => 2, 'D' => 3, 'C' => 4, 'C+' => 5, 'B' => 6, 'B+' => 7, 'A-' => 8, 'A' => 9, 'A+' => 10];
        return $grades[strtoupper($grade)] ?? 0;
    }

    /**
     * Check if SPM/STPM results meet a target pattern (e.g. '5A', '5C', '8B+').
     */
    private function checkSpmResult($results, $target): bool
    {
        if (empty($results) || !$target)
            return false;

        // Count number of A's if target contains 'A' (e.g. '5A', '5A+')
        if (preg_match('/^(\d+)A(\+)?$/i', $target, $matches)) {
            $requiredCount = (int) $matches[1];
            $count = 0;
            foreach ($results as $grade) {
                if (isset($matches[2]) && $matches[2] === '+') {
                    if ($grade === 'A+')
                        $count++;
                } else {
                    if (in_array($grade, ['A+', 'A', 'A-']))
                        $count++;
                }
            }
            return $count >= $requiredCount;
        }

        // Count number of Credits (C or better)
        if (preg_match('/^(\d+)C$/i', $target, $matches)) {
            $requiredCount = (int) $matches[1];
            $count = 0;
            foreach ($results as $grade) {
                if ($this->gradeValue($grade) >= $this->gradeValue('C'))
                    $count++;
            }
            return $count >= $requiredCount;
        }

        // Count number of B+ or better for '8B+'
        if (preg_match('/^(\d+)B\+$/i', $target, $matches)) {
            $requiredCount = (int) $matches[1];
            $count = 0;
            foreach ($results as $grade) {
                if ($this->gradeValue($grade) >= $this->gradeValue('B+'))
                    $count++;
            }
            return $count >= $requiredCount;
        }

        return false;
    }

    /**
     * Get the numeric grade value for a specific subject from results.
     */
    private function getSubjectGrade($results, $subject): int
    {
        if (empty($results))
            return 0;
        foreach ($results as $name => $grade) {
            if (strtolower($name) === strtolower($subject)) {
                return $this->gradeValue($grade);
            }
        }
        return 0;
    }

    // ─── Recommendation Engine ───────────────────────────────────────

    private function runRecommendationEngine($q): array
    {
        $results = [];
        $user = $q->user;

        // Normalize inputs
        $citizenship = strtolower(trim($user->nationality ?? ''));
        $birthstate = strtolower(trim($user->birth_state ?? ''));
        $age = $user->dob ? \Carbon\Carbon::parse($user->dob)->age : 0;
        $study_location = strtolower(trim($user->study_location ?? ''));
        $study_country = strtolower(trim($user->study_country ?? ''));
        $place_of_study = strtolower(trim($user->place_of_study ?? ''));
        $is_top_100 = $user->is_top_100_university ?? false;

        $father_birthstate = strtolower(trim($q->father_birthstate ?? ''));
        $mother_birthstate = strtolower(trim($q->mother_birthstate ?? ''));
        $current_state = strtolower(trim($q->current_state ?? ''));
        $enrollment_status = strtolower(trim($q->enrollment_status ?? ''));
        $income_category = strtolower(trim($q->income_category ?? ''));
        $education_level = strtolower(trim($q->education_level ?? ''));
        $spm = $q->spm_results ?? [];
        $stpm = $q->stpm_results ?? [];

        // ── Rule 1: Biasiswa Perdana – Diploma ──
        $m = [];
        $ms = [];
        $total = 10;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'sabah', 'Born in Sabah');
        $this->addCriteria($m, $ms, $father_birthstate === 'sabah' || $mother_birthstate === 'sabah', 'Sabah Origin (Parent)');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5A'), 'Minimum 5A in SPM');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A'), 'Bahasa Melayu (A)');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'English') >= $this->gradeValue('C'), 'English (C)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 20, 'Age Eligibility (<= 20)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $education_level === 'diploma', 'Applying for Diploma');
        $results[] = ['name' => 'BIASISWA PERDANA - BIASISWA KERAJAAN NEGERI SABAH', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 2: Biasiswa Perdana – Bachelor ──
        $m = [];
        $ms = [];
        $total = 7;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'sabah', 'Born in Sabah');
        $this->addCriteria($m, $ms, $father_birthstate === 'sabah' || $mother_birthstate === 'sabah', 'Sabah Origin (Parent)');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.00 || $q->stpm_cgpa >= 3.00 || $q->foundation_cgpa >= 3.00, 'Min CGPA 3.00 (Diploma/STPM/Found)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 25, 'Age Eligibility (<= 25)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'BIASISWA PERDANA - BIASISWA KERAJAAN NEGERI SABAH', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 3: Biasiswa Perdana – Master ──
        $m = [];
        $ms = [];
        $total = 7;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'sabah', 'Born in Sabah');
        $this->addCriteria($m, $ms, $father_birthstate === 'sabah' || $mother_birthstate === 'sabah', 'Sabah Origin (Parent)');
        $this->addCriteria($m, $ms, $q->bachelor_cgpa >= 3.50, 'Min Bachelor CGPA 3.50');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 30, 'Age Eligibility (<= 30)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $education_level === 'master', 'Applying for Master');
        $results[] = ['name' => 'BIASISWA PERDANA - BIASISWA KERAJAAN NEGERI SABAH', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 4: Biasiswa Cemerlang Negeri Sabah (BCNS) ──
        $m = [];
        $ms = [];
        $total = 8;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'sabah', 'Born in Sabah');
        $this->addCriteria($m, $ms, $father_birthstate === 'sabah' || $mother_birthstate === 'sabah', 'Sabah Origin (Parent)');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5A+'), 'Minimum 5A+ in SPM');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A+'), 'Bahasa Melayu (A+)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 35, 'Age Eligibility (<= 35)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'Biasiswa Cemerlang Negeri Sabah (BCNS)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 5: Biasiswa Cemerlang Pelajar Luar Bandar (BCPLB) ──
        $m = [];
        $ms = [];
        $total = 8;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'sabah', 'Born in Sabah');
        $this->addCriteria($m, $ms, $father_birthstate === 'sabah' || $mother_birthstate === 'sabah', 'Sabah Origin (Parent)');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5A'), 'Minimum 5A in SPM');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A'), 'Bahasa Melayu (A)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $income_category === 'b40', 'Income Category: B40');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'Biasiswa Cemerlang Pelajar Luar Bandar (BCPLB)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 6: Yayasan Terengganu ──
        $m = [];
        $ms = [];
        $total = 11;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'terengganu', 'Born in Terengganu');
        $this->addCriteria($m, $ms, $father_birthstate === 'terengganu' || $mother_birthstate === 'terengganu', 'Terengganu Origin (Parent)');
        $this->addCriteria($m, $ms, $income_category === 'b40', 'Income Category: B40');
        $this->addCriteria($m, $ms, $q->foundation_cgpa >= 3.75 || $q->stpm_cgpa >= 3.75, 'Min CGPA 3.75 (Found/STPM)');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '8B+'), 'Minimum 8B+ in SPM');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('B+'), 'Bahasa Melayu (B+)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 25, 'Age Eligibility (<= 25)');
        $this->addCriteria($m, $ms, $this->muetNumeric($q->muet_band) >= 3, 'MUET Band (>= 3)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'Biasiswa Skim Pelajar Cemerlang Yayasan Terengganu', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 7: Biasiswa Khas Dato’ Menteri Besar Selangor ──
        $m = [];
        $ms = [];
        $total = 8;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'selangor' || ($q->years_resident >= 10 && $current_state === 'selangor'), 'Selangor Origin/Resident');
        $this->addCriteria($m, $ms, $enrollment_status === 'full-time', 'Full-Time Enrollment');
        $this->addCriteria($m, $ms, $q->household_income > 0 && $q->household_income <= 20000, 'Household Income (<= RM20,000)');
        $this->addCriteria($m, $ms, $q->foundation_cgpa >= 3.75 || ($q->bachelor_cgpa >= 3.75 && $this->muetNumeric($q->muet_band) >= 5) || $q->bachelor_cgpa >= 3.75, 'High Academic Performance');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 40, 'Age Eligibility (<= 40)');
        $this->addCriteria($m, $ms, $is_top_100 || $q->research_proposal, 'Top 100 Uni OR Approved Research Proposal');
        $this->addCriteria($m, $ms, $education_level !== 'diploma', 'Not Applying for Diploma');
        $results[] = ['name' => "Biasiswa Khas Dato' Menteri Besar Selangor", 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 8: Biasiswa Sarawak Tunku Abdul Rahman (YBSTAR) ──
        $m = [];
        $ms = [];
        $total = 5;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'sarawak' || $father_birthstate === 'sarawak' || $mother_birthstate === 'sarawak', 'Sarawak Origin');
        $this->addCriteria($m, $ms, $q->foundation_cgpa >= 3.00 || $q->stpm_cgpa >= 3.00 || ($q->bachelor_cgpa >= 3.00 && $study_location === 'local') || $q->bachelor_cgpa >= 3.00 || $q->master_cgpa >= 3.00, 'Min CGPA 3.00');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') > $this->gradeValue('C'), 'Bahasa Melayu (> C)');
        $this->addCriteria($m, $ms, $education_level !== 'diploma', 'Not Applying for Diploma');
        $results[] = ['name' => 'Biasiswa Sarawak Tunku Abdul Rahman (YBSTAR)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 9: Pinjaman Boleh Ubah Luar Negara (PBULN) ──
        $m = [];
        $ms = [];
        $total = 8;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $birthstate === 'selangor' || ($q->years_resident >= 10 && $current_state === 'selangor'), 'Selangor Origin/Resident');
        $this->addCriteria($m, $ms, $enrollment_status === 'full-time', 'Full-Time Enrollment');
        $this->addCriteria($m, $ms, in_array($study_country, ['egypt', 'jordan', 'morocco', 'mesir', 'maghribi']), 'Middle East Institution (Mesir/Jordan/Maghribi)');
        $this->addCriteria($m, $ms, $income_category === 'b40', 'Income Category: B40');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5C') || $this->checkSpmResult($stpm, '4C'), 'Min SPM 5C / STPM 4C');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') > $this->gradeValue('C'), 'Bahasa Melayu (> C)');
        $this->addCriteria($m, $ms, $education_level !== 'diploma', 'Not Applying for Diploma');
        $results[] = ['name' => 'Pinjaman Boleh Ubah Luar Negara (PBULN)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 10: Khazanah Watan Scholarship Program ──
        $m = [];
        $ms = [];
        $total = 8;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.50 || $q->foundation_cgpa >= 3.50 || $q->bachelor_cgpa >= 3.50 || $this->checkSpmResult($stpm, '3A'), 'Min CGPA 3.50 / STPM 3A');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 21, 'Age Eligibility (<= 21)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $q->year_of_bachelor_study == 1, 'First Year Student');
        $f = strtolower($q->field_of_study ?? '');
        $this->addCriteria($m, $ms, $f !== 'medicine' && $f !== 'dentistry' && $f !== 'architecture', 'Field of Study (Excl. Med/Dent/Arch)');
        $khazanahUnis = [
            'asia pacific university of technology & innovation',
            'inceif university',
            'universiti teknologi mara',
            'international islamic university malaysia',
            'universiti kebanksaan malaysia',
            'multimedia university',
            'universiti putra malaysia',
            'universiti sains malaysia',
            'universiti teknologi malaysia',
            'universiti tenaga nasional',
            'universiti utara malaysia',
            'universiti malaya'
        ];
        $this->addCriteria($m, $ms, in_array($place_of_study, $khazanahUnis), 'Eligible University (Khazanah List)');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'Khazanah Watan Scholarship Program', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 11: Kijang Undergraduate Scholarship ──
        $m = [];
        $ms = [];
        $total = 8;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.50 || $q->foundation_cgpa >= 3.50 || $q->stpm_cgpa >= 3.50 || $q->bachelor_cgpa >= 3.50, 'Min CGPA 3.50');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5C'), 'Minimum 5C in SPM');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('C'), 'Bahasa Melayu (C)');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'English') >= $this->gradeValue('C'), 'English (C)');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Mathematics') >= $this->gradeValue('C'), 'Mathematics (C)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 22, 'Age Eligibility (<= 22)');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'Kijang Undergraduate Scholarship', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 12: YSD Undergraduate Excellence Scholarship ──
        $m = [];
        $ms = [];
        $total = 6;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $q->household_income > 0 && $q->household_income <= 11000, 'Household Income (<= RM11,000)');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.30 || $q->foundation_cgpa >= 3.30 || $q->stpm_cgpa >= 3.30, 'Min CGPA 3.30 (Diploma/Found/STPM)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 25, 'Age Eligibility (<= 25)');
        $ysdUnis = [
            'monash university malaysia',
            'universiti malaya',
            'university of nottingham malaysia',
            'universiti kebangsaan malaysia',
            'universiti putra malaysia',
            'universiti sains malaysia',
            'universiti teknologi malaysia',
            'universiti teknologi petronas',
            'taylor’s university',
            'ucsi university'
        ];
        $this->addCriteria($m, $ms, in_array($place_of_study, $ysdUnis), 'Eligible University (YSD List)');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'YSD Undergraduate Excellence Scholarship', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 13: Scholarship 1 by Provider 1 ──
        $m = [];
        $ms = [];
        $total = 10;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.90 || $q->foundation_cgpa >= 2.00 || $q->stpm_cgpa >= 3.00 || $q->bachelor_cgpa >= 3.80, 'High Academic CGPA');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5A'), 'Minimum 5A in SPM');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A'), 'Bahasa Melayu (A)');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Sejarah') >= $this->gradeValue('A'), 'Sejarah (A)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 25, 'Age Eligibility (<= 25)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $this->muetNumeric($q->muet_band) >= 4, 'MUET Band (>= 4)');
        $this->addCriteria($m, $ms, $this->cefrValue($q->cefr) >= $this->cefrValue('C1'), 'CEFR Level (>= C1)');
        $this->addCriteria($m, $ms, $education_level === 'bachelor', 'Applying for Bachelor');
        $results[] = ['name' => 'Scholarship 1', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // Deduplicate (keep highest score per name) and sort
        $unique = [];
        foreach ($results as $r) {
            $name = $r['name'];
            if (!isset($unique[$name]) || $unique[$name]['score'] < $r['score']) {
                $unique[$name] = $r;
            }
        }

        usort($unique, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_slice($unique, 0, 3);
    }
}

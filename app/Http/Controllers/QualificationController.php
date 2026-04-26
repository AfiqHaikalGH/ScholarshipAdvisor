<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use App\Models\Recommendation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index()
    {
        $qualification = auth()->user()->qualification ?? new Qualification();
        return view('qualifications.index', compact('qualification'));
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
            'research_proposal' => 'nullable|boolean',
            'muet_band' => 'nullable|string',
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
        $cached = Recommendation::where('user_id', auth()->id())->orderBy('rank')->get();
        if ($cached->isEmpty()) {
            return view('qualifications.recommendations', ['recommendations' => null]);
        }

        $recommendations = $cached->map(function ($r) {
            return [
                'name' => $r->scholarship_name,
                'score' => $r->score,
                'matches' => $r->matches ?? [],
                'missing' => $r->missing ?? [],
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

        // Extract and normalize user profile fields
        $citizenship = strtolower(trim($user->nationality ?? ''));
        $birthstate = strtolower(trim($user->birth_state ?? ''));
        $age = $user->dob ? Carbon::parse($user->dob)->age : 0;
        $study_location = strtolower(trim($user->study_location ?? ''));
        $study_country = strtolower(trim($user->study_country ?? ''));
        $is_top_100 = $user->is_top_100_university ?? false;

        // Extract and normalize qualification fields
        $father_birthstate = strtolower(trim($q->father_birthstate ?? ''));
        $mother_birthstate = strtolower(trim($q->mother_birthstate ?? ''));
        $current_state = strtolower(trim($q->current_state ?? ''));
        $enrollment_status = strtolower(trim($q->enrollment_status ?? ''));
        $income_category = strtolower(trim($q->income_category ?? ''));
        $education_level = strtolower(trim($q->education_level ?? ''));
        $spm = $q->spm_results ?? [];
        $stpm = $q->stpm_results ?? [];

        // ── Rule 1: Biasiswa Perdana – Diploma ──
        $isSabah = ($birthstate === 'sabah' || $father_birthstate === 'sabah' || $mother_birthstate === 'sabah');
        if ($isSabah) {
            $m = [];
            $ms = [];
            $total = 8;
            $m[] = 'Sabah Origin (Applicant or Parent)';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $age > 0 && $age <= 20, 'Age Eligibility (<= 20)');
            $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
            $this->addCriteria($m, $ms, $education_level === 'diploma', 'Level: Diploma');
            $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5A'), 'Minimum 5A in SPM');
            $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A'), 'Bahasa Melayu (A)');
            $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'English') >= $this->gradeValue('C'), 'English (C)');
            if (count($m) > 0)
                $results[] = ['name' => 'Biasiswa Perdana - Biasiswa Kerajaan Negeri Sabah', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 2: Biasiswa Perdana – General UG ──
        if ($isSabah) {
            $m = [];
            $ms = [];
            $total = 5;
            $m[] = 'Sabah Origin (Applicant or Parent)';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $age > 0 && $age <= 25, 'Age Eligibility (<= 25)');
            $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
            $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.00 || $q->stpm_cgpa >= 3.00 || $q->foundation_cgpa >= 3.00, 'Minimum CGPA 3.00 (Entry Level)');
            if (count($m) > 0)
                $results[] = ['name' => 'Biasiswa Perdana - Biasiswa Kerajaan Negeri Sabah', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 3: Biasiswa Perdana – Bachelor ──
        if ($isSabah) {
            $m = [];
            $ms = [];
            $total = 5;
            $m[] = 'Sabah Origin (Applicant or Parent)';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $age > 0 && $age <= 30, 'Age Eligibility (<= 30)');
            $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
            $this->addCriteria($m, $ms, $q->bachelor_cgpa >= 3.50, 'Minimum Bachelor CGPA 3.50');
            if (count($m) > 0)
                $results[] = ['name' => 'Biasiswa Perdana - Biasiswa Kerajaan Negeri Sabah', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 4: Biasiswa Cemerlang Negeri Sabah (BCNS) ──
        if ($isSabah) {
            $m = [];
            $ms = [];
            $total = 6;
            $m[] = 'Sabah Origin (Applicant or Parent)';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $age > 0 && $age <= 35, 'Age Eligibility (<= 35)');
            $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
            $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5A+'), 'Minimum 5A+ in SPM');
            $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A+'), 'Bahasa Melayu (A+)');
            if (count($m) > 0)
                $results[] = ['name' => 'Biasiswa Cemerlang Negeri Sabah (BCNS)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 5: Biasiswa Cemerlang Pelajar Luar Bandar (BCPLP) ──
        if ($isSabah) {
            $m = [];
            $ms = [];
            $total = 6;
            $m[] = 'Sabah Origin (Applicant or Parent)';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
            $this->addCriteria($m, $ms, $income_category === 'b40', 'Income Category: B40');
            $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5A'), 'Minimum 5A in SPM');
            $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A'), 'Bahasa Melayu (A)');
            if (count($m) > 0)
                $results[] = ['name' => 'Biasiswa Cemerlang Pelajar Luar Bandar (BCPLP)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 6: Yayasan Terengganu ──
        $isTerengganu = ($birthstate === 'terengganu' || $father_birthstate === 'terengganu' || $mother_birthstate === 'terengganu');
        if ($isTerengganu) {
            $m = [];
            $ms = [];
            $total = 8;
            $m[] = 'Terengganu Origin (Applicant or Parent)';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $income_category === 'b40', 'Income Category: B40');
            $this->addCriteria($m, $ms, $age > 0 && $age <= 25, 'Age Eligibility (<= 25)');
            $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
            $this->addCriteria($m, $ms, $q->foundation_cgpa >= 3.75 || $q->stpm_cgpa >= 3.75, 'Minimum CGPA 3.75 (Entry Level)');
            $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '8B+'), 'Minimum 8B+ in SPM');
            $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('B+'), 'Bahasa Melayu (B+)');
            $this->addCriteria($m, $ms, $this->muetNumeric($q->muet_band) >= 3, 'MUET Band (>= 3)');
            if (count($m) > 0)
                $results[] = ['name' => 'Biasiswa Skim Pelajar Cemerlang Yayasan Terengganu', 'score' => (min(count($m), $total) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 7: Dato' Menteri Besar Selangor ──
        $isSelangorStrict = (($birthstate === 'selangor' && ($father_birthstate === 'selangor' || $mother_birthstate === 'selangor')) || ($q->years_resident >= 10 && $current_state === 'selangor'));
        if ($isSelangorStrict) {
            $m = [];
            $ms = [];
            $total = 7;
            $m[] = 'Selangor Origin/Resident';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $enrollment_status === 'full-time', 'Full-Time Enrollment');
            $this->addCriteria($m, $ms, $q->household_income > 0 && $q->household_income <= 20000, 'Household Income (<= RM20,000)');
            $this->addCriteria($m, $ms, $age > 0 && $age <= 40, 'Age Eligibility (<= 40)');
            $this->addCriteria($m, $ms, $q->foundation_cgpa >= 3.75 || $q->bachelor_cgpa >= 3.75, 'High Academic Performance (CGPA >= 3.75)');
            $this->addCriteria($m, $ms, $q->research_proposal || $is_top_100, 'Top 100 Uni / Research Proposal');
            if (count($m) > 0)
                $results[] = ['name' => "Biasiswa Khas Dato' Menteri Besar Selangor", 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 8: Biasiswa Sarawak Tunku Abdul Rahman (YBSTAR) ──
        $isSarawak = ($birthstate === 'sarawak' || $father_birthstate === 'sarawak' || $mother_birthstate === 'sarawak');
        if ($isSarawak) {
            $m = [];
            $ms = [];
            $total = 4;
            $m[] = 'Sarawak Origin (Applicant or Parent)';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $q->foundation_cgpa >= 3.00 || $q->stpm_cgpa >= 3.00 || ($q->bachelor_cgpa >= 3.00 && $study_location === 'local') || $q->bachelor_cgpa >= 3.00 || $q->master_cgpa >= 3.00, 'Minimum CGPA 3.00');
            $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') > $this->gradeValue('C'), 'Bahasa Melayu (> C)');
            if (count($m) > 0)
                $results[] = ['name' => 'Biasiswa Sarawak Tunku Abdul Rahman (YBSTAR)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 9: Pinjaman Boleh Ubah Luar Negara (PBULN) ──
        if ($isSelangorStrict) {
            $m = [];
            $ms = [];
            $total = 6;
            $m[] = 'Selangor Origin/Resident';
            $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
            $this->addCriteria($m, $ms, $enrollment_status === 'full-time', 'Full-Time Enrollment');
            $this->addCriteria($m, $ms, $income_category === 'b40', 'Income Category: B40');
            $this->addCriteria($m, $ms, in_array($study_country, ['egypt', 'jordan', 'morocco', 'mesir', 'maghribi']), 'Middle East Institution');
            $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5C') || $this->checkSpmResult($stpm, '4C'), 'Minimum Grade C (SPM/STPM)');
            if (count($m) > 0)
                $results[] = ['name' => 'Pinjaman Boleh Ubah Luar Negara (PBULN)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // ── Rule 10: Khazanah Watan Scholarship Program ──
        $m = [];
        $ms = [];
        $total = 6;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 21, 'Age Eligibility (<= 21)');
        $this->addCriteria($m, $ms, $study_location === 'local', 'Local Institution');
        $this->addCriteria($m, $ms, $q->year_of_bachelor_study == 1, 'First Year Student');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.50 || $q->foundation_cgpa >= 3.50 || $q->bachelor_cgpa >= 3.50 || $this->checkSpmResult($stpm, '3A'), 'Minimum CGPA 3.50 / STPM 3A');
        $f = strtolower($q->field_of_study ?? '');
        $this->addCriteria($m, $ms, $f !== 'medicine' && $f !== 'dentistry' && $f !== 'architecture', 'Eligible Field of Study');
        if (count($m) > 0)
            $results[] = ['name' => 'Khazanah Watan Scholarship Program', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 11: Kijang Undergraduate Scholarship ──
        $m = [];
        $ms = [];
        $total = 6;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 22, 'Age Eligibility (<= 22)');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.50 || $q->foundation_cgpa >= 3.50 || $q->stpm_cgpa >= 3.50 || $q->bachelor_cgpa >= 3.50, 'Minimum CGPA 3.50');
        $this->addCriteria($m, $ms, $this->checkSpmResult($spm, '5C'), 'Minimum 5C in SPM');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('C'), 'Bahasa Melayu (C)');
        $this->addCriteria($m, $ms, $this->getSubjectGrade($spm, 'English') >= $this->gradeValue('C') && $this->getSubjectGrade($spm, 'Mathematics') >= $this->gradeValue('C'), 'English & Math (C)');
        if (count($m) > 0)
            $results[] = ['name' => 'Kijang Undergraduate Scholarship', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // ── Rule 12: YSD Undergraduate Excellence Scholarship ──
        $m = [];
        $ms = [];
        $total = 4;
        $this->addCriteria($m, $ms, $citizenship === 'malaysian', 'Malaysian Citizenship');
        $this->addCriteria($m, $ms, $q->household_income > 0 && $q->household_income <= 11000, 'Household Income (<= RM11,000)');
        $this->addCriteria($m, $ms, $age > 0 && $age <= 25, 'Age Eligibility (<= 25)');
        $this->addCriteria($m, $ms, $q->diploma_cgpa >= 3.30 || $q->foundation_cgpa >= 3.30 || $q->stpm_cgpa >= 3.30, 'Minimum CGPA 3.30');
        if (count($m) > 0)
            $results[] = ['name' => 'YSD Undergraduate Excellence Scholarship', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

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

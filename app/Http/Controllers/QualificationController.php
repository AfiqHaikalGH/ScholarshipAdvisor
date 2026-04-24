<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index()
    {
        $qualification = auth()->user()->qualification ?? new \App\Models\Qualification();
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
            if (!$level || $val === null) continue;
            switch ($level) {
                case 'Diploma': $data['diploma_cgpa'] = $val; break;
                case 'STPM': $data['stpm_cgpa'] = $val; break;
                case 'Foundation/Matriculation': $data['foundation_cgpa'] = $val; break;
                case 'Bachelor': $data['bachelor_cgpa'] = $val; break;
                case 'Master': $data['master_cgpa'] = $val; break;
            }
        }

        $spmNames = $request->input('spm_subject_name', []);
        $spmGrades = $request->input('spm_subject_grade', []);
        $spmResults = [];
        foreach($spmNames as $index => $name) {
            if (!empty($name) && !empty($spmGrades[$index])) {
                $spmResults[$name] = strtoupper(trim($spmGrades[$index]));
            }
        }
        $data['spm_results'] = $spmResults;

        $stpmNames = $request->input('stpm_subject_name', []);
        $stpmGrades = $request->input('stpm_subject_grade', []);
        $stpmResults = [];
        foreach($stpmNames as $index => $name) {
            if (!empty($name) && !empty($stpmGrades[$index])) {
                $stpmResults[$name] = strtoupper(trim($stpmGrades[$index]));
            }
        }
        $data['stpm_results'] = $stpmResults;

        $data['research_proposal'] = $request->has('research_proposal');

        $qualification = \App\Models\Qualification::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        // Run recommendation engine and cache results
        $results = $this->runRecommendationEngine($qualification);
        \App\Models\Recommendation::where('user_id', auth()->id())->delete();
        foreach ($results as $rank => $r) {
            \App\Models\Recommendation::create([
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
        $cached = \App\Models\Recommendation::where('user_id', auth()->id())->orderBy('rank')->get();
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

    private function muetNumeric($val)
    {
        if (!$val) return 0;
        $v = trim($val);
        if ($v === '5+') return 6;
        return floatval($v);
    }

    private function gradeValue($grade)
    {
        if (!$grade) return 0;
        $grades = ['G'=>1, 'E'=>2, 'D'=>3, 'C'=>4, 'C+'=>5, 'B'=>6, 'B+'=>7, 'A-'=>8, 'A'=>9, 'A+'=>10];
        return $grades[strtoupper($grade)] ?? 0;
    }

    private function checkSpmResult($results, $target)
    {
        if (empty($results) || !$target) return false;
        
        // Count number of A's if target contains 'A' (e.g. '5A', '5A+')
        if (preg_match('/^(\d+)A(\+)?$/i', $target, $matches)) {
            $requiredCount = (int)$matches[1];
            $count = 0;
            foreach ($results as $grade) {
                if (isset($matches[2]) && $matches[2] === '+') {
                    if ($grade === 'A+') $count++;
                } else {
                    if (in_array($grade, ['A+', 'A', 'A-'])) $count++;
                }
            }
            return $count >= $requiredCount;
        }

        // Count number of Credits (C or better)
        if (preg_match('/^(\d+)C$/i', $target, $matches)) {
            $requiredCount = (int)$matches[1];
            $count = 0;
            foreach ($results as $grade) {
                if ($this->gradeValue($grade) >= $this->gradeValue('C')) $count++;
            }
            return $count >= $requiredCount;
        }
        
        // Count number of B+ or better for '8B+'
        if (preg_match('/^(\d+)B\+$/i', $target, $matches)) {
            $requiredCount = (int)$matches[1];
            $count = 0;
            foreach ($results as $grade) {
                if ($this->gradeValue($grade) >= $this->gradeValue('B+')) $count++;
            }
            return $count >= $requiredCount;
        }

        return false;
    }

    private function getSubjectGrade($results, $subject) {
        if (empty($results)) return 0;
        foreach ($results as $name => $grade) {
            if (strtolower($name) === strtolower($subject)) {
                return $this->gradeValue($grade);
            }
        }
        return 0;
    }

    private function runRecommendationEngine($q)
    {
        $results = [];
        $user = $q->user;
        $citizenship = strtolower(trim($user->nationality ?? ''));
        $birthstate = strtolower(trim($user->birth_state ?? ''));
        $age = $user->dob ? \Carbon\Carbon::parse($user->dob)->age : 0;
        $place_of_study = strtolower(trim($user->place_of_study ?? ''));
        $study_location = strtolower(trim($user->study_location ?? ''));
        $study_country = strtolower(trim($user->study_country ?? ''));
        $is_top_100 = $user->is_top_100_university ?? false;
        $father_birthstate = strtolower(trim($q->father_birthstate ?? ''));
        $mother_birthstate = strtolower(trim($q->mother_birthstate ?? ''));
        $current_state = strtolower(trim($q->current_state ?? ''));
        $enrollment_status = strtolower(trim($q->enrollment_status ?? ''));
        $income_category = strtolower(trim($q->income_category ?? ''));
        $education_level = strtolower(trim($q->education_level ?? ''));
        $spm = $q->spm_results ?? [];
        $stpm = $q->stpm_results ?? [];

        // Rule 1: Biasiswa Perdana (Diploma)
        $isSabah = ($birthstate === 'sabah' || $father_birthstate === 'sabah' || $mother_birthstate === 'sabah');
        if ($isSabah) {
            $m = []; $ms = []; $total = 9;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($age > 0 && $age <= 20) $m[] = 'Age Eligibility (<= 20)'; else $ms[] = 'Age Eligibility (<= 20)';
            if ($study_location === 'local') $m[] = 'Local Institution'; else $ms[] = 'Local Institution';
            if ($education_level === 'diploma') $m[] = 'Level: Diploma'; else $ms[] = 'Level: Diploma';
            if ($birthstate === 'sabah') $m[] = 'Sabah Born'; else $ms[] = 'Sabah Born';
            if ($father_birthstate === 'sabah' || $mother_birthstate === 'sabah') $m[] = 'Parent(s) Sabah Born'; else $ms[] = 'Parent(s) Sabah Born';
            if ($this->checkSpmResult($spm, '5A')) $m[] = 'Minimum 5A in SPM'; else $ms[] = 'Minimum 5A in SPM';
            if ($this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A')) $m[] = 'Bahasa Melayu (A)'; else $ms[] = 'Bahasa Melayu (A)';
            if ($this->getSubjectGrade($spm, 'English') >= $this->gradeValue('C')) $m[] = 'English (C)'; else $ms[] = 'English (C)';
            if (count($m) > 0) $results[] = ['name' => 'Biasiswa Perdana - Biasiswa Kerajaan Negeri Sabah', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 2: Biasiswa Perdana (General UG)
        if ($isSabah) {
            $m = []; $ms = []; $total = 6;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($age > 0 && $age <= 25) $m[] = 'Age Eligibility (<= 25)'; else $ms[] = 'Age Eligibility (<= 25)';
            if ($study_location === 'local') $m[] = 'Local Institution'; else $ms[] = 'Local Institution';
            if ($birthstate === 'sabah') $m[] = 'Sabah Born'; else $ms[] = 'Sabah Born';
            if ($father_birthstate === 'sabah' || $mother_birthstate === 'sabah') $m[] = 'Parent(s) Sabah Born'; else $ms[] = 'Parent(s) Sabah Born';
            if ($q->diploma_cgpa >= 3.00 || $q->stpm_cgpa >= 3.00 || $q->foundation_cgpa >= 3.00) $m[] = 'Minimum CGPA 3.00 (Entry Level)'; else $ms[] = 'Minimum CGPA 3.00 (Entry Level)';
            if (count($m) > 0) $results[] = ['name' => 'Biasiswa Perdana - Biasiswa Kerajaan Negeri Sabah', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 3: Biasiswa Perdana (Bachelor)
        if ($isSabah) {
            $m = []; $ms = []; $total = 6;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($age > 0 && $age <= 30) $m[] = 'Age Eligibility (<= 30)'; else $ms[] = 'Age Eligibility (<= 30)';
            if ($study_location === 'local') $m[] = 'Local Institution'; else $ms[] = 'Local Institution';
            if ($birthstate === 'sabah') $m[] = 'Sabah Born'; else $ms[] = 'Sabah Born';
            if ($father_birthstate === 'sabah' || $mother_birthstate === 'sabah') $m[] = 'Parent(s) Sabah Born'; else $ms[] = 'Parent(s) Sabah Born';
            if ($q->bachelor_cgpa >= 3.50) $m[] = 'Minimum Bachelor CGPA 3.50'; else $ms[] = 'Minimum Bachelor CGPA 3.50';
            if (count($m) > 0) $results[] = ['name' => 'Biasiswa Perdana - Biasiswa Kerajaan Negeri Sabah', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 4: BCNS
        if ($isSabah) {
            $m = []; $ms = []; $total = 7;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($age > 0 && $age <= 35) $m[] = 'Age Eligibility (<= 35)'; else $ms[] = 'Age Eligibility (<= 35)';
            if ($study_location === 'local') $m[] = 'Local Institution'; else $ms[] = 'Local Institution';
            if ($birthstate === 'sabah') $m[] = 'Sabah Born'; else $ms[] = 'Sabah Born';
            if ($father_birthstate === 'sabah' || $mother_birthstate === 'sabah') $m[] = 'Parent(s) Sabah Born'; else $ms[] = 'Parent(s) Sabah Born';
            if ($this->checkSpmResult($spm, '5A+')) $m[] = 'Minimum 5A+ in SPM'; else $ms[] = 'Minimum 5A+ in SPM';
            if ($this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A+')) $m[] = 'Bahasa Melayu (A+)'; else $ms[] = 'Bahasa Melayu (A+)';
            if (count($m) > 0) $results[] = ['name' => 'Biasiswa Cemerlang Negeri Sabah (BCNS)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 5: BCPLP
        if ($isSabah) {
            $m = []; $ms = []; $total = 7;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($study_location === 'local') $m[] = 'Local Institution'; else $ms[] = 'Local Institution';
            if ($income_category === 'b40') $m[] = 'Income Category: B40'; else $ms[] = 'Income Category: B40';
            if ($birthstate === 'sabah') $m[] = 'Sabah Born'; else $ms[] = 'Sabah Born';
            if ($father_birthstate === 'sabah' || $mother_birthstate === 'sabah') $m[] = 'Parent(s) Sabah Born'; else $ms[] = 'Parent(s) Sabah Born';
            if ($this->checkSpmResult($spm, '5A')) $m[] = 'Minimum 5A in SPM'; else $ms[] = 'Minimum 5A in SPM';
            if ($this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('A')) $m[] = 'Bahasa Melayu (A)'; else $ms[] = 'Bahasa Melayu (A)';
            if (count($m) > 0) $results[] = ['name' => 'Biasiswa Cemerlang Pelajar Luar Bandar (BCPLP)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 6: Yayasan Terengganu
        $isTerengganu = ($birthstate === 'terengganu' || $father_birthstate === 'terengganu' || $mother_birthstate === 'terengganu');
        if ($isTerengganu) {
            $m = []; $ms = []; $total = 9;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($income_category === 'b40') $m[] = 'Income Category: B40'; else $ms[] = 'Income Category: B40';
            if ($age > 0 && $age <= 25) $m[] = 'Age Eligibility (<= 25)'; else $ms[] = 'Age Eligibility (<= 25)';
            if ($study_location === 'local') $m[] = 'Local Institution'; else $ms[] = 'Local Institution';
            if ($birthstate === 'terengganu') $m[] = 'Terengganu Born'; else $ms[] = 'Terengganu Born';
            if ($father_birthstate === 'terengganu' || $mother_birthstate === 'terengganu') $m[] = 'Parent(s) Terengganu Born'; else $ms[] = 'Parent(s) Terengganu Born';
            if ($q->foundation_cgpa >= 3.75 || $q->stpm_cgpa >= 3.75) $m[] = 'Minimum CGPA 3.75 (Entry Level)'; else $ms[] = 'Minimum CGPA 3.75 (Entry Level)';
            if ($this->checkSpmResult($spm, '8B+')) $m[] = 'Minimum 8B+ in SPM'; else $ms[] = 'Minimum 8B+ in SPM';
            if ($this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('B+')) $m[] = 'Bahasa Melayu (B+)'; else $ms[] = 'Bahasa Melayu (B+)';
            if ($this->muetNumeric($q->muet_band) >= 3) $m[] = 'MUET Band (>= 3)'; else $ms[] = 'MUET Band (>= 3)';
            if (count($m) > 0) $results[] = ['name' => 'Biasiswa Skim Pelajar Cemerlang Yayasan Terengganu', 'score' => (min(count($m), $total) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 7: Dato' Menteri Besar Selangor
        $isSelangor = ($birthstate === 'selangor' || $father_birthstate === 'selangor' || $mother_birthstate === 'selangor' || ($q->years_resident >= 10 && $current_state === 'selangor'));
        if ($isSelangor) {
            $m = []; $ms = []; $total = 7;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($enrollment_status === 'full-time') $m[] = 'Full-Time Enrollment'; else $ms[] = 'Full-Time Enrollment';
            if ($q->household_income > 0 && $q->household_income <= 20000) $m[] = 'Household Income (<= RM20,000)'; else $ms[] = 'Household Income (<= RM20,000)';
            if ($age > 0 && $age <= 40) $m[] = 'Age Eligibility (<= 40)'; else $ms[] = 'Age Eligibility (<= 40)';
            if (($birthstate === 'selangor' && ($father_birthstate === 'selangor' || $mother_birthstate === 'selangor')) || ($q->years_resident >= 10 && $current_state === 'selangor')) $m[] = 'Selangor Origin/Resident'; else $ms[] = 'Selangor Origin/Resident';
            if ($q->foundation_cgpa >= 3.75 || ($q->bachelor_cgpa >= 3.75 && $this->muetNumeric($q->muet_band) >= 5) || $q->bachelor_cgpa >= 3.75) $m[] = 'High Academic Performance (CGPA >= 3.75)'; else $ms[] = 'High Academic Performance (CGPA >= 3.75)';
            if ($q->research_proposal || $is_top_100) $m[] = 'Top 100 Uni / Research Proposal'; else $ms[] = 'Top 100 Uni / Research Proposal';
            if (count($m) > 0) $results[] = ['name' => "Biasiswa Khas Dato' Menteri Besar Selangor", 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 8: YBSTAR
        $isSarawak = ($birthstate === 'sarawak' || $father_birthstate === 'sarawak' || $mother_birthstate === 'sarawak');
        if ($isSarawak) {
            $m = []; $ms = []; $total = 5;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($birthstate === 'sarawak') $m[] = 'Sarawak Born'; else $ms[] = 'Sarawak Born';
            if ($father_birthstate === 'sarawak' || $mother_birthstate === 'sarawak') $m[] = 'Parent(s) Sarawak Born'; else $ms[] = 'Parent(s) Sarawak Born';
            if ($q->foundation_cgpa >= 3.00 || $q->stpm_cgpa >= 3.00 || ($q->bachelor_cgpa >= 3.00 && $study_location === 'local') || $q->bachelor_cgpa >= 3.00 || $q->master_cgpa >= 3.00) $m[] = 'Minimum CGPA 3.00'; else $ms[] = 'Minimum CGPA 3.00';
            if ($this->getSubjectGrade($spm, 'Bahasa Melayu') > $this->gradeValue('C')) $m[] = 'Bahasa Melayu (> C)'; else $ms[] = 'Bahasa Melayu (> C)';
            if (count($m) > 0) $results[] = ['name' => 'Biasiswa Sarawak Tunku Abdul Rahman (YBSTAR)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 9: PBULN
        if ($isSelangor) {
            $m = []; $ms = []; $total = 6;
            if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
            if ($enrollment_status === 'full-time') $m[] = 'Full-Time Enrollment'; else $ms[] = 'Full-Time Enrollment';
            if ($income_category === 'b40') $m[] = 'Income Category: B40'; else $ms[] = 'Income Category: B40';
            if (in_array($study_country, ['egypt', 'jordan', 'morocco', 'mesir', 'maghribi'])) $m[] = 'Middle East Institution'; else $ms[] = 'Middle East Institution';
            if (($birthstate === 'selangor' && ($father_birthstate === 'selangor' || $mother_birthstate === 'selangor')) || ($q->years_resident >= 10 && $current_state === 'selangor')) $m[] = 'Selangor Origin/Resident'; else $ms[] = 'Selangor Origin/Resident';
            if ($this->checkSpmResult($spm, '5C') || $this->checkSpmResult($stpm, '4C')) $m[] = 'Minimum Grade C (SPM/STPM)'; else $ms[] = 'Minimum Grade C (SPM/STPM)';
            if (count($m) > 0) $results[] = ['name' => 'Pinjaman Boleh Ubah Luar Negara (PBULN)', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];
        }

        // Rule 9 (Second): Khazanah Watan
        $m = []; $ms = []; $total = 6;
        if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
        if ($age > 0 && $age <= 21) $m[] = 'Age Eligibility (<= 21)'; else $ms[] = 'Age Eligibility (<= 21)';
        if ($study_location === 'local') $m[] = 'Local Institution'; else $ms[] = 'Local Institution';
        if ($q->year_of_bachelor_study == 1) $m[] = 'First Year Student'; else $ms[] = 'First Year Student';
        if ($q->diploma_cgpa >= 3.50 || $q->foundation_cgpa >= 3.50 || $q->bachelor_cgpa >= 3.50 || $this->checkSpmResult($stpm, '3A')) $m[] = 'Minimum CGPA 3.50 / STPM 3A'; else $ms[] = 'Minimum CGPA 3.50 / STPM 3A';
        $f = strtolower($q->field_of_study ?? '');
        if ($f !== 'medicine' && $f !== 'dentistry' && $f !== 'architecture') $m[] = 'Eligible Field of Study'; else $ms[] = 'Eligible Field of Study';
        if (count($m) > 0) $results[] = ['name' => 'Khazanah Watan Scholarship Program', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // Rule 10: Kijang Undergraduate
        $m = []; $ms = []; $total = 6;
        if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
        if ($age > 0 && $age <= 22) $m[] = 'Age Eligibility (<= 22)'; else $ms[] = 'Age Eligibility (<= 22)';
        if ($q->diploma_cgpa >= 3.50 || $q->foundation_cgpa >= 3.50 || $q->stpm_cgpa >= 3.50 || $q->bachelor_cgpa >= 3.50) $m[] = 'Minimum CGPA 3.50'; else $ms[] = 'Minimum CGPA 3.50';
        if ($this->checkSpmResult($spm, '5C')) $m[] = 'Minimum 5C in SPM'; else $ms[] = 'Minimum 5C in SPM';
        if ($this->getSubjectGrade($spm, 'Bahasa Melayu') >= $this->gradeValue('C')) $m[] = 'Bahasa Melayu (C)'; else $ms[] = 'Bahasa Melayu (C)';
        if ($this->getSubjectGrade($spm, 'English') >= $this->gradeValue('C') && $this->getSubjectGrade($spm, 'Mathematics') >= $this->gradeValue('C')) $m[] = 'English & Math (C)'; else $ms[] = 'English & Math (C)';
        if (count($m) > 0) $results[] = ['name' => 'Kijang Undergraduate Scholarship', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // Rule 11: YSD Undergraduate
        $m = []; $ms = []; $total = 4;
        if ($citizenship === 'malaysian') $m[] = 'Malaysian Citizenship'; else $ms[] = 'Malaysian Citizenship';
        if ($q->household_income > 0 && $q->household_income <= 11000) $m[] = 'Household Income (<= RM11,000)'; else $ms[] = 'Household Income (<= RM11,000)';
        if ($age > 0 && $age <= 25) $m[] = 'Age Eligibility (<= 25)'; else $ms[] = 'Age Eligibility (<= 25)';
        if ($q->diploma_cgpa >= 3.30 || $q->foundation_cgpa >= 3.30 || $q->stpm_cgpa >= 3.30) $m[] = 'Minimum CGPA 3.30'; else $ms[] = 'Minimum CGPA 3.30';
        if (count($m) > 0) $results[] = ['name' => 'YSD Undergraduate Excellence Scholarship', 'score' => (count($m) / $total) * 100, 'matches' => $m, 'missing' => $ms];

        // Deduplicate and Sort
        $unique = [];
        foreach ($results as $r) {
            $name = $r['name'];
            if (!isset($unique[$name]) || $unique[$name]['score'] < $r['score']) {
                $unique[$name] = $r;
            }
        }

        usort($unique, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_slice($unique, 0, 3);
    }
}

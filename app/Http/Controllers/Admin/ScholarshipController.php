<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\ScholarshipLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ScholarshipController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

        public function create()
    {
        $providers = Scholarship::whereNotNull('provider')->select('provider')->distinct()->pluck('provider');
        return view('admin.create-scholarship', compact('providers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'provider' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount_per_year' => ['nullable', 'numeric', 'min:0'],
            'application_start_date' => ['nullable', 'date'],
            'application_end_date' => ['nullable', 'date', 'after_or_equal:application_start_date'],
            'application_status' => ['nullable', 'in:Open,Closed,Upcoming'],
            'citizenship' => ['nullable', 'string', 'max:255'],
            'income_category' => ['nullable', 'in:B40,M40,T20'],
            'health_requirement' => ['nullable', 'string', 'max:255'],
            'bond_duration' => ['nullable', 'integer', 'min:0'],
            'bond_organization' => ['nullable', 'string', 'max:255'],
            'education_levels'    => ['required', 'array', 'min:1'],
            'education_levels.*.place_of_study' => ['nullable', 'string', 'max:255'],
            'education_levels.*.min_spm_result' => ['nullable', 'string', 'max:255'],
            'education_levels.*.field_of_study' => ['nullable', 'array'],
            'education_levels.*.field_of_study.*' => ['nullable', 'string', 'max:255'],
            'education_levels.*.muet_band' => ['nullable', 'string', 'in:Band 1,Band 2,Band 3,Band 4,Band 5,Band 6'],
            'education_levels.*.cefr' => ['nullable', 'in:A1,A2,B1,B2,C1,C2'],
            'education_levels.*.age_limit' => ['nullable', 'integer', 'min:0'],
            'education_levels.*.min_diploma_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_foundation_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_stpm_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_bachelor_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_master_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.spm_subject_name' => ['nullable', 'array'],
            'education_levels.*.spm_subject_name.*' => ['nullable', 'string', 'max:100'],
            'education_levels.*.spm_subject_grade' => ['nullable', 'array'],
            'education_levels.*.spm_subject_grade.*' => ['nullable', 'string', 'max:20'],
            'education_levels.*.additional_requirements' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Fixed 4-level labels in order
            $levelLabels = ['Diploma', 'Bachelor', 'Master', 'PhD'];
            $levelLabel = implode(', ', $levelLabels);

            $scholarship = Scholarship::create([
                'name' => $validated['name'],
                'provider' => $validated['provider'] ?? null,
                'level' => $levelLabel,
                'description' => $validated['description'] ?? null,
                'amount_per_year' => $validated['amount_per_year'] ?? null,
                'application_start_date' => $validated['application_start_date'] ?? null,
                'application_end_date' => $validated['application_end_date'] ?? null,
                'application_status' => $validated['application_status'] ?? 'Open',
                'min_stpm_cgpa' => null,
                'min_matriculation_cgpa' => null,
                'min_diploma_cgpa' => null,
                'min_spm_result' => null,
                'cefr' => null,
                'spm_subjects' => null,
                'field_of_study' => null,
                'place_of_study' => null,
                'citizenship' => $validated['citizenship'] ?? null,
                'age_limit' => $validated['education_levels'][0]['age_limit'] ?? null,
                'income_category' => $validated['income_category'] ?? null,
                'health_requirement' => $validated['health_requirement'] ?? null,
                'has_other_scholarship_restriction'  => $request->boolean('has_other_scholarship_restriction'),
                'blacklist_status'                    => $request->boolean('blacklist_status'),
                'bond_required'                       => $request->boolean('bond_required'),
                'bond_duration'                       => $validated['bond_duration'] ?? null,
                'bond_organization'                   => $validated['bond_organization'] ?? null,
            ]);

            foreach ($validated['education_levels'] as $idx => $educationLevel) {
                $spmSubjects = [];
                $subjectNames = $educationLevel['spm_subject_name'] ?? [];
                $subjectGrades = $educationLevel['spm_subject_grade'] ?? [];

                foreach ($subjectNames as $index => $subjectName) {
                    $grade = $subjectGrades[$index] ?? null;
                    if (!empty($subjectName) && !empty($grade)) {
                        if (isset($spmSubjects[$subjectName])) {
                            throw ValidationException::withMessages([
                                'education_levels' => 'Duplicate SPM subjects are not allowed in the same education level.',
                            ]);
                        }
                        $spmSubjects[$subjectName] = $grade;
                    }
                }

                $levelRequirements = array_filter([
                    'place_of_study' => $educationLevel['place_of_study'] ?? null,
                    'min_spm_result' => $educationLevel['min_spm_result'] ?? null,
                    'spm_subjects' => empty($spmSubjects) ? null : $spmSubjects,
                    'field_of_study' => $educationLevel['field_of_study'] ?? null,
                    'cefr' => $educationLevel['cefr'] ?? null,
                    'additional_requirements' => $educationLevel['additional_requirements'] ?? null,
                ], fn($value) => !is_null($value) && $value !== '');

                $scholarship->scholarshipLevels()->create([
                    'education_levels' => [$levelLabels[$idx] ?? 'Diploma'],
                    'min_diploma_cgpa' => $educationLevel['min_diploma_cgpa'] ?? null,
                    'min_foundation_cgpa' => $educationLevel['min_foundation_cgpa'] ?? null,
                    'min_stpm_cgpa' => $educationLevel['min_stpm_cgpa'] ?? null,
                    'min_bachelor_cgpa' => $educationLevel['min_bachelor_cgpa'] ?? null,
                    'min_master_cgpa' => $educationLevel['min_master_cgpa'] ?? null,
                    'muet_band' => $educationLevel['muet_band'] ?? null,
                    'age_limit' => $educationLevel['age_limit'] ?? null,
                    'additional_requirements' => empty($levelRequirements) ? null : json_encode($levelRequirements),
                ]);
            }
        });

        return back()->with('success', 'Scholarship details saved successfully.');
    }

    public function edit($id)
    {
        $scholarship = Scholarship::with('scholarshipLevels')->findOrFail($id);
        $providers = Scholarship::whereNotNull('provider')->select('provider')->distinct()->pluck('provider');

        // Pre-decode scholarship levels for the edit form
        $scholarship->scholarshipLevels->each(function ($level) {
            if (is_string($level->education_levels)) {
                $level->education_levels = json_decode($level->education_levels, true) ?? [];
            }
            if (is_string($level->additional_requirements)) {
                $level->additional_requirements_decoded = json_decode($level->additional_requirements, true) ?? [];
            }
        });

        return view('admin.edit-scholarship', compact('scholarship', 'providers'));
    }

    public function update(Request $request, $id)
    {
        $scholarship = Scholarship::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'provider' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount_per_year' => ['nullable', 'numeric', 'min:0'],
            'application_start_date' => ['nullable', 'date'],
            'application_end_date' => ['nullable', 'date', 'after_or_equal:application_start_date'],
            'application_status' => ['nullable', 'in:Open,Closed,Upcoming'],
            'citizenship' => ['nullable', 'string', 'max:255'],
            'income_category' => ['nullable', 'in:B40,M40,T20'],
            'health_requirement' => ['nullable', 'string', 'max:255'],
            'bond_duration' => ['nullable', 'integer', 'min:0'],
            'bond_organization' => ['nullable', 'string', 'max:255'],
            'education_levels'    => ['required', 'array', 'min:1'],
            'education_levels.*.place_of_study' => ['nullable', 'string', 'max:255'],
            'education_levels.*.min_spm_result' => ['nullable', 'string', 'max:255'],
            'education_levels.*.field_of_study' => ['nullable', 'array'],
            'education_levels.*.field_of_study.*' => ['nullable', 'string', 'max:255'],
            'education_levels.*.muet_band' => ['nullable', 'string', 'in:Band 1,Band 2,Band 3,Band 4,Band 5,Band 6'],
            'education_levels.*.cefr' => ['nullable', 'in:A1,A2,B1,B2,C1,C2'],
            'education_levels.*.age_limit' => ['nullable', 'integer', 'min:0'],
            'education_levels.*.min_diploma_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_foundation_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_stpm_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_bachelor_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.min_master_cgpa' => ['nullable', 'numeric', 'between:0,4'],
            'education_levels.*.spm_subject_name' => ['nullable', 'array'],
            'education_levels.*.spm_subject_name.*' => ['nullable', 'string', 'max:100'],
            'education_levels.*.spm_subject_grade' => ['nullable', 'array'],
            'education_levels.*.spm_subject_grade.*' => ['nullable', 'string', 'max:20'],
            'education_levels.*.additional_requirements' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($scholarship, $validated, $request) {
            // Fixed 4-level labels in order
            $levelLabels = ['Diploma', 'Bachelor', 'Master', 'PhD'];
            $levelLabel = implode(', ', $levelLabels);

            $scholarship->update([
                'name' => $validated['name'],
                'provider' => $validated['provider'] ?? null,
                'level' => $levelLabel,
                'description' => $validated['description'] ?? null,
                'amount_per_year' => $validated['amount_per_year'] ?? null,
                'application_start_date' => $validated['application_start_date'] ?? null,
                'application_end_date' => $validated['application_end_date'] ?? null,
                'application_status' => $validated['application_status'] ?? 'Open',
                'min_stpm_cgpa' => null,
                'min_matriculation_cgpa' => null,
                'min_diploma_cgpa' => null,
                'min_spm_result' => null,
                'cefr' => null,
                'spm_subjects' => null,
                'field_of_study' => null,
                'place_of_study' => null,
                'citizenship' => $validated['citizenship'] ?? null,
                'age_limit' => $validated['education_levels'][0]['age_limit'] ?? null,
                'income_category' => $validated['income_category'] ?? null,
                'health_requirement' => $validated['health_requirement'] ?? null,
                'has_other_scholarship_restriction'  => $request->boolean('has_other_scholarship_restriction'),
                'blacklist_status'                    => $request->boolean('blacklist_status'),
                'bond_required'                       => $request->boolean('bond_required'),
                'bond_duration'                       => $validated['bond_duration'] ?? null,
                'bond_organization'                   => $validated['bond_organization'] ?? null,
            ]);

            $scholarship->scholarshipLevels()->delete();

            foreach ($validated['education_levels'] as $idx => $educationLevel) {
                $spmSubjects = [];
                $subjectNames = $educationLevel['spm_subject_name'] ?? [];
                $subjectGrades = $educationLevel['spm_subject_grade'] ?? [];

                foreach ($subjectNames as $index => $subjectName) {
                    $grade = $subjectGrades[$index] ?? null;
                    if (!empty($subjectName) && !empty($grade)) {
                        if (isset($spmSubjects[$subjectName])) {
                            throw ValidationException::withMessages([
                                'education_levels' => 'Duplicate SPM subjects are not allowed in the same education level.',
                            ]);
                        }
                        $spmSubjects[$subjectName] = $grade;
                    }
                }

                $levelRequirements = array_filter([
                    'place_of_study' => $educationLevel['place_of_study'] ?? null,
                    'min_spm_result' => $educationLevel['min_spm_result'] ?? null,
                    'spm_subjects' => empty($spmSubjects) ? null : $spmSubjects,
                    'field_of_study' => $educationLevel['field_of_study'] ?? null,
                    'cefr' => $educationLevel['cefr'] ?? null,
                    'additional_requirements' => $educationLevel['additional_requirements'] ?? null,
                ], fn($value) => !is_null($value) && $value !== '');

                $scholarship->scholarshipLevels()->create([
                    'education_levels' => [$levelLabels[$idx] ?? 'Diploma'],
                    'min_diploma_cgpa' => $educationLevel['min_diploma_cgpa'] ?? null,
                    'min_foundation_cgpa' => $educationLevel['min_foundation_cgpa'] ?? null,
                    'min_stpm_cgpa' => $educationLevel['min_stpm_cgpa'] ?? null,
                    'min_bachelor_cgpa' => $educationLevel['min_bachelor_cgpa'] ?? null,
                    'min_master_cgpa' => $educationLevel['min_master_cgpa'] ?? null,
                    'muet_band' => $educationLevel['muet_band'] ?? null,
                    'age_limit' => $educationLevel['age_limit'] ?? null,
                    'additional_requirements' => empty($levelRequirements) ? null : json_encode($levelRequirements),
                ]);
            }
        });

        return back()->with('success', 'Scholarship updated successfully.');
    }

    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();

        return back()->with('success', 'Scholarship deleted successfully.');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'level',
        'programme_levels',
        'description',
        'amount_per_year',
        'application_start_date',
        'application_end_date',
        'application_status',
        'min_stpm_cgpa',
        'min_matriculation_cgpa',
        'min_diploma_cgpa',
        'min_spm_result',
        'cefr',
        'spm_subjects',
        'field_of_study',
        'place_of_study',
        'citizenship',
        'age_limit',
        'income_category',
        'health_requirement',
        'has_other_scholarship_restriction',
        'blacklist_status',
        'bond_required',
        'bond_duration',
        'bond_organization',
    ];

    protected $casts = [
        'programme_levels'                  => 'array',
        'spm_subjects'                       => 'array',
        'has_other_scholarship_restriction'  => 'boolean',
        'blacklist_status'                   => 'boolean',
        'bond_required'                      => 'boolean',
    ];

    public function scholarshipLevels()
    {
        return $this->hasMany(ScholarshipLevel::class);
    }
}

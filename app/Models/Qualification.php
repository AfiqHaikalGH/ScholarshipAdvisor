<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'user_id',
        'father_birthstate',
        'mother_birthstate',
        'years_resident',
        'current_state',
        'household_income',
        'income_category',
        'education_level',
        'enrollment_status',
        'field_of_study',
        'year_of_bachelor_study',
        'current_bachelor_cgpa',
        'research_proposal',
        'spm_results',
        'stpm_results',
        'muet_band',
        'diploma_cgpa',
        'stpm_cgpa',
        'foundation_cgpa',
        'bachelor_cgpa',
        'master_cgpa',
    ];

    protected $casts = [
        'spm_results' => 'array',
        'stpm_results' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipLevel extends Model
{
    protected $table = 'scholarship_levels';

    protected $fillable = [
        'scholarship_id',
        'education_levels',
        'min_diploma_cgpa',
        'min_foundation_cgpa',
        'min_stpm_cgpa',
        'min_bachelor_cgpa',
        'min_master_cgpa',
        'muet_band',
        'age_limit',
        'additional_requirements',
    ];

    protected $casts = [
        'education_levels' => 'array',
    ];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }
}

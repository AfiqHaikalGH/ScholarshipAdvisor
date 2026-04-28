<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'level',
        'description',
        'amount_per_year',
        'application_start_date',
        'application_end_date',
        'application_status',
        'citizenship',
        'income_category',
        'health_requirement',
        'has_other_scholarship_restriction',
        'blacklist_status',
        'bond_required',
        'bond_duration',
        'bond_organization',
    ];

    protected $casts = [
        'has_other_scholarship_restriction'  => 'boolean',
        'blacklist_status'                   => 'boolean',
        'bond_required'                      => 'boolean',
    ];

    public function scholarshipLevels()
    {
        return $this->hasMany(ScholarshipLevel::class);
    }
}

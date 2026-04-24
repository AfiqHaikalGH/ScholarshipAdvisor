<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'user_id',
        'scholarship_name',
        'score',
        'matches',
        'missing',
        'rank',
    ];

    protected $casts = [
        'matches' => 'array',
        'missing' => 'array',
        'score'   => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

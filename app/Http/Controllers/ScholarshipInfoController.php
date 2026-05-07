<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipInfoController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::query();

        // Scope scholarships for representatives
        if (auth()->check() && auth()->user()->role === 'representative') {
            $query->where('provider', auth()->user()->provider_name);
        }

        // 1. Keyword Search (Name, Description, Provider, or Requirements)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('provider', 'like', "%{$searchTerm}%")
                  ->orWhereHas('scholarshipLevels', function($sq) use ($searchTerm) {
                      $sq->where('additional_requirements', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // 2. Provider Filter
        if ($request->filled('provider') && $request->provider !== 'All') {
            $query->where('provider', $request->provider);
        }

        // 3. Education Level (Check related scholarship_levels table - ignore empty placeholders)
        if ($request->filled('level')) {
            $levels = (array) $request->level;
            $query->whereHas('scholarshipLevels', function($q) use ($levels) {
                $q->where(function($sq) use ($levels) {
                    foreach ($levels as $level) {
                        // Using LIKE for JSON string compatibility in SQLite
                        $sq->orWhere('education_levels', 'like', '%"' . $level . '"%');
                    }
                })->where(function($sq) {
                    // Stricter check: Must have at least one academic requirement
                    $sq->where(function($inner) {
                        $inner->where('min_diploma_cgpa', '>', 0)
                          ->orWhere('min_foundation_cgpa', '>', 0)
                          ->orWhere('min_stpm_cgpa', '>', 0)
                          ->orWhere('min_bachelor_cgpa', '>', 0)
                          ->orWhere('min_master_cgpa', '>', 0)
                          ->orWhereNotNull('muet_band')
                          ->orWhereNotNull('age_limit');
                    })->orWhere(function($inner) {
                        $inner->whereNotNull('additional_requirements')
                              ->where('additional_requirements', '!=', '[]')
                              ->where('additional_requirements', '!=', '{}')
                              ->where('additional_requirements', '!=', '');
                    });
                });
            });
        }



        // Fetch results with pagination
        $scholarships = $query->latest()->paginate(12)->withQueryString();

        // Fetch distinct providers for the sidebar dropdown
        $providers = Scholarship::whereNotNull('provider')->select('provider')->distinct()->pluck('provider');

        return view('scholarship-info', compact('scholarships', 'providers'));
    }

    public function show($id)
    {
        $scholarship = Scholarship::with('scholarshipLevels')->findOrFail($id);

        return view('scholarships.show', compact('scholarship'));
    }
}

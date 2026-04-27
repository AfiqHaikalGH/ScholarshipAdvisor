<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipInfoController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::query();

        // 1. Keyword Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // 2. Provider Filter
        if ($request->filled('provider') && $request->provider !== 'All') {
            $query->where('provider', $request->provider);
        }

        // 3. Education Level
        if ($request->filled('level')) {
            $query->where(function($q) use ($request) {
                foreach ((array) $request->level as $level) {
                    $q->orWhereJsonContains('programme_levels', $level);
                }
            });
        }

        // 4. Place of Study
        if ($request->filled('location') && $request->location !== 'All') {
            $query->where('place_of_study', 'like', "%{$request->location}%");
        }

        // Fetch paginated results ordered by latest
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

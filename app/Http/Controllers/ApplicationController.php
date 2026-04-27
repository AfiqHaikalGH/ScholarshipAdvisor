<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Recommendation;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display all eligible (100% match) recommended scholarships with their applied status.
     */
    public function index()
    {
        $userId = auth()->id();

        // All 100% match recommendations for this student
        $recommendations = Recommendation::where('user_id', $userId)
            ->where('score', '>=', 100)
            ->orderBy('scholarship_name')
            ->get();

        // Existing application records keyed by scholarship name for O(1) lookup
        $applications = Application::where('user_id', $userId)
            ->get()
            ->keyBy('scholarship_name');

        // Build a unified list combining recommendation + application data
        $scholarships = $recommendations->map(function ($rec) use ($applications) {
            $scholarship = Scholarship::where('name', $rec->scholarship_name)->first();
            $application = $applications->get($rec->scholarship_name);

            return [
                'scholarship_name'   => $rec->scholarship_name,
                'deadline'           => $scholarship?->application_end_date,
                'applied'            => $application !== null,
                'acceptance_status'  => $application?->acceptance_status,
            ];
        });

        return view('applications.index', compact('scholarships'));
    }

    /**
     * Record that the student applied to a scholarship, then redirect them to the external portal.
     * Returns JSON when called via AJAX so the frontend can open the URL in a new tab.
     */
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'scholarship_name' => 'required|string|max:255',
            'apply_url'        => 'required|string|max:500',
        ]);

        Application::firstOrCreate(
            [
                'user_id'          => auth()->id(),
                'scholarship_name' => $validated['scholarship_name'],
            ],
            [
                'apply_url'         => $validated['apply_url'],
                'acceptance_status' => 'Pending',
                'applied_at'        => now(),
            ]
        );

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->away($validated['apply_url']);
    }
}

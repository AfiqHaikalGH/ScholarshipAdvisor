<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    /**
     * List all non-admin users.
     */
    public function index()
    {
        $students = User::where('role', '!=', 'admin')
            ->orderBy('name')
            ->get();

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show all application records for a specific student.
     */
    public function applications(User $user)
    {
        $applications = Application::where('user_id', $user->id)
            ->orderByDesc('applied_at')
            ->get();

        $appliedNames = $applications->pluck('scholarship_name');

        // Show recommended-but-not-applied scholarships separately
        $notApplied = Recommendation::where('user_id', $user->id)
            ->whereNotIn('scholarship_name', $appliedNames)
            ->pluck('scholarship_name');

        return view('admin.students.applications', compact('user', 'applications', 'notApplied'));
    }

    /**
     * Update the acceptance status of a specific application.
     */
    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'acceptance_status' => 'required|in:Pending,Accepted,Rejected',
        ]);

        $application->update($validated);

        return back()->with('success', 'Application status updated successfully.');
    }
}

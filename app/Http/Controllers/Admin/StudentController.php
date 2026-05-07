<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && !in_array(auth()->user()->role, ['admin', 'representative'])) {
            abort(403);
        }
    }

    /**
     * List students or applications depending on the admin role.
     */
    public function index()
    {
        if (auth()->user()->role === 'representative') {
            $providerName = auth()->user()->provider_name;
            $scholarshipNames = \App\Models\Scholarship::where('provider', $providerName)->pluck('name');
            $query = Application::with('user')->whereIn('scholarship_name', $scholarshipNames);
            $applications = $query->orderByDesc('applied_at')->paginate(20);
            $this->attachProofUrls($applications);
            return view('admin.students.representative_index', compact('applications'));
        }

        // Main Admin view: List of all students
        $students = User::whereNotIn('role', ['admin', 'representative'])
            ->orderBy('name')
            ->get();

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show all application records for a specific student (Main Admin only).
     */
    public function applications(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $applications = Application::where('user_id', $user->id)
            ->orderByDesc('applied_at')
            ->get();
        $this->attachProofUrls($applications);

        return view('admin.students.applications', compact('user', 'applications'));
    }

    private function attachProofUrls($applications): void
    {
        $diskName = config('filesystems.default');
        $driver = config('filesystems.disks.' . $diskName . '.driver');
        $disk = Storage::disk($diskName);

        foreach ($applications as $application) {
            $application->proof_url = null;

            if (!$application->proof_path) {
                continue;
            }

            $application->proof_url = $driver === 's3'
                ? $disk->temporaryUrl($application->proof_path, now()->addMinutes(15))
                : $disk->url($application->proof_path);
        }
    }

    /**
     * Update the acceptance status of a specific application.
     */
    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:Not Apply,Applied,Approved,Rejected',
        ]);

        if (auth()->user()->role === 'representative') {
            $providerName = auth()->user()->provider_name;
            $scholarship = \App\Models\Scholarship::where('name', $application->scholarship_name)->first();
            if (!$scholarship || $scholarship->provider !== $providerName) {
                abort(403, 'Unauthorized action.');
            }
        }

        $application->update($validated);

        return back()->with('success', 'Application status updated successfully.');
    }
}

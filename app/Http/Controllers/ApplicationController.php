<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Recommendation;
use App\Models\Scholarship;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $disk = Storage::disk(config('filesystems.default'));
        $driver = config('filesystems.disks.' . config('filesystems.default') . '.driver');

        // Build a unified list combining recommendation + application data
        $scholarships = $recommendations->map(function ($rec) use ($applications) {
            $scholarship = Scholarship::where('name', $rec->scholarship_name)->first();
            $application = $applications->get($rec->scholarship_name);

            return [
                'id' => $application?->id,
                'scholarship_name' => $rec->scholarship_name,
                'deadline' => $scholarship?->application_end_date,
                'applied' => $application !== null,
                'status' => $application?->status,
                'proof_path' => $application?->proof_path,
                'proof_url' => $application?->proof_path
                    ? ($driver === 's3'
                        ? $disk->temporaryUrl($application->proof_path, now()->addMinutes(15))
                        : $disk->url($application->proof_path))
                    : null,
                'is_proof_submitted' => $application?->is_proof_submitted ?? false,
                'is_offline' => empty($scholarship?->apply_url),
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
            'apply_url' => 'required|string|max:500',
        ]);

        Application::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'scholarship_name' => $validated['scholarship_name'],
            ],
            [
                'apply_url' => $validated['apply_url'],
                'status' => 'Not Apply',
                'applied_at' => now(),
            ]
        );

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->away($validated['apply_url']);
    }

    /**
     * Handle the upload of application proof.
     */
    public function uploadProof(Request $request, Application $application)
    {
        // Ensure user owns this application
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB Max
        ]);

        if ($request->hasFile('proof')) {
            try {
                // Store file using the configured filesystem disk (s3/public/local).
                $diskName = config('filesystems.default');
                $disk = \Illuminate\Support\Facades\Storage::disk($diskName);
                $path = $disk->putFile('proofs', $request->file('proof'));
                if (!$path) {
                    throw new \RuntimeException("Upload returned an empty path on disk [{$diskName}].");
                }

                $application->update([
                    'proof_path' => $path,
                ]);

                return back()->with('success', 'Attachment saved successfully! You can now view, delete, or submit it.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to upload proof: ' . $e->getMessage());
                return back()->withErrors(['proof' => 'Failed to upload file to the storage server. Please try again later.']);
            }
        }

        return back()->withErrors(['proof' => 'Failed to upload proof.']);
    }

    /**
     * Delete the uploaded application proof.
     */
    public function deleteProof(Application $application)
    {
        // Ensure user owns this application
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow deletion if it hasn't been submitted yet
        if ($application->is_proof_submitted) {
            return back()->withErrors(['proof' => 'Cannot delete a proof that has already been submitted.']);
        }

        if ($application->proof_path) {
            \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->delete($application->proof_path);
            $application->update(['proof_path' => null]);
        }

        return back()->with('success', 'Attachment deleted successfully.');
    }

    /**
     * Submit the uploaded application proof for admin review.
     */
    public function submitProof(Application $application)
    {
        // Ensure user owns this application
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$application->proof_path) {
            return back()->withErrors(['proof' => 'Please upload an attachment first before submitting.']);
        }

        $application->update(['is_proof_submitted' => true]);

        return back()->with('success', 'Proof of application submitted successfully! It is now pending admin review.');
    }

    /**
     * Display recommended scholarships for the student to start an application.
     */
    public function start()
    {
        $user = auth()->user();
        $recommendations = \App\Models\Recommendation::where('user_id', $user->id)
            ->orderBy('rank')
            ->take(3) // Get top 3 overall first
            ->get()
            ->map(function ($r) {
                $scholarship = \App\Models\Scholarship::where('name', $r->scholarship_name)->first();
                return [
                    'name' => $r->scholarship_name,
                    'provider' => $scholarship ? $scholarship->provider : 'N/A',
                    'is_offline' => $scholarship ? empty($scholarship->apply_url) : true,
                ];
            })
            ->filter(function ($rec) {
                return $rec['is_offline']; // Only show if it's offline
            });

        return view('applications.start', compact('recommendations'));
    }

    /**
     * Show the prefilled offline application form.
     */
    public function offlineForm(Request $request)
    {
        $scholarshipName = $request->query('scholarship');
        if (!$scholarshipName) {
            return redirect()->route('applications.start')->withErrors(['msg' => 'Scholarship name is required.']);
        }

        $user = auth()->user();
        $qualification = $user->qualification;

        return view('applications.offline-form', compact('scholarshipName', 'user', 'qualification'));
    }

    /**
     * Generate PDF from the offline form submission and optionally update profile.
     */
    public function generatePdf(Request $request)
    {
        $validated = $request->validate([
            'scholarship_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_num' => 'required|string|max:50',
            'ic_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'birth_state' => 'nullable|string|max:100',
            'nationality' => 'nullable|string|max:100',
            'gender' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone_num' => $validated['phone_num'],
            'ic_number' => $validated['ic_number'],
            'address' => $validated['address'],
            'birth_state' => $validated['birth_state'],
            'nationality' => $validated['nationality'],
            'gender' => $validated['gender'],
        ]);

        $qualification = $user->qualification;
        $scholarshipName = $validated['scholarship_name'];

        // Automatically create the application record so it appears in the status page
        \App\Models\Application::firstOrCreate(
            [
                'user_id' => $user->id,
                'scholarship_name' => $scholarshipName,
            ],
            [
                'apply_url' => '', // Empty string for offline applications to satisfy DB constraint
                'status' => 'Not Apply',
                'applied_at' => now(),
            ]
        );

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('applications.pdf', compact('user', 'qualification', 'scholarshipName'));
        
        return $pdf->download(str_replace(' ', '_', $scholarshipName) . '_Application.pdf');
    }

    /**
     * Save profile information from the offline form without generating PDF.
     */
    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_num' => 'required|string|max:50',
            'ic_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'birth_state' => 'nullable|string|max:100',
            'nationality' => 'nullable|string|max:100',
            'gender' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone_num' => $validated['phone_num'],
            'ic_number' => $validated['ic_number'],
            'address' => $validated['address'],
            'birth_state' => $validated['birth_state'],
            'nationality' => $validated['nationality'],
            'gender' => $validated['gender'],
        ]);

        return back()->with('success', 'Personal information saved successfully!');
    }
}

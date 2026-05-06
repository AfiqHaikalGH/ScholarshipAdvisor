<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ─── Authenticated Routes ────────────────────────────────────────────────────

Route::middleware(['auth'])->group(function () {

    // Scholarship Information Page (default post-login landing page)
    Route::get('/scholarship-info', [\App\Http\Controllers\ScholarshipInfoController::class, 'index'])->name('scholarship.info');
    Route::get('/scholarships/{id}', [\App\Http\Controllers\ScholarshipInfoController::class, 'show'])->name('scholarships.show');

    // Dashboard (legacy) — redirect to main scholarship page
    Route::get('/dashboard', function () {
        return redirect()->route('scholarship.info');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Qualifications & Recommendations
    Route::get('/qualifications', [\App\Http\Controllers\QualificationController::class, 'index'])->name('qualifications.index');
    Route::post('/qualifications/filter', [\App\Http\Controllers\QualificationController::class, 'filter'])->name('qualifications.filter');
    Route::get('/recommendations', [\App\Http\Controllers\QualificationController::class, 'recommendations'])->name('qualifications.recommendations');

    // Applications (student)
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/applications/apply', [ApplicationController::class, 'apply'])->name('applications.apply');
    Route::post('/applications/{application}/upload-proof', [ApplicationController::class, 'uploadProof'])->name('applications.upload-proof');
    Route::delete('/applications/{application}/proof', [ApplicationController::class, 'deleteProof'])->name('applications.delete-proof');
    Route::post('/applications/{application}/submit-proof', [ApplicationController::class, 'submitProof'])->name('applications.submit-proof');

    // Offline Applications
    Route::get('/applications/start', [ApplicationController::class, 'start'])->name('applications.start');
    Route::get('/applications/offline-form', [ApplicationController::class, 'offlineForm'])->name('applications.offline-form');
    Route::post('/applications/generate-pdf', [ApplicationController::class, 'generatePdf'])->name('applications.generate-pdf');
    Route::post('/applications/save-profile', [ApplicationController::class, 'saveProfile'])->name('applications.save-profile');

    // Admin-only routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role !== 'admin') {
                abort(403);
            }
            return view('admin.dashboard');
        });

        // Admin Account Creation & Management
        Route::resource('admins', \App\Http\Controllers\Admin\AdminAccountController::class)->except(['show']);

        // Scholarship Management
        Route::get('/scholarships/create', [ScholarshipController::class, 'create'])->name('scholarships.create');
        Route::post('/scholarships', [ScholarshipController::class, 'store'])->name('scholarships.store');
        Route::get('/scholarships/{id}/edit', [ScholarshipController::class, 'edit'])->name('scholarships.edit');
        Route::put('/scholarships/{id}', [ScholarshipController::class, 'update'])->name('scholarships.update');
        Route::delete('/scholarships/{id}', [ScholarshipController::class, 'destroy'])->name('scholarships.destroy');

        // Student Management
        Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
        Route::get('/students/{user}/applications', [StudentController::class, 'applications'])->name('admin.students.applications');
        Route::patch('/applications/{application}/status', [StudentController::class, 'updateStatus'])->name('admin.applications.updateStatus');
    });
});

require __DIR__ . '/auth.php';

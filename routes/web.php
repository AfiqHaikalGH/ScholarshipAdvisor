<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ScholarshipController;

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

    // Dashboard (legacy)
    Route::get('/dashboard', function () {
        return view('dashboard');
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

    // Admin-only routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role !== 'admin') {
                abort(403);
            }
            return view('admin.dashboard');
        });

        // Admin Account Creation
        Route::get('/create-admin', [\App\Http\Controllers\Admin\AdminAccountController::class, 'create'])->name('admin.create');
        Route::post('/create-admin', [\App\Http\Controllers\Admin\AdminAccountController::class, 'store'])->name('admin.store');

        // Scholarship Management
        Route::get('/scholarships/create', [ScholarshipController::class, 'create'])->name('scholarships.create');
        Route::post('/scholarships', [ScholarshipController::class, 'store'])->name('scholarships.store');
        Route::get('/scholarships/{id}/edit', [ScholarshipController::class, 'edit'])->name('scholarships.edit');
        Route::put('/scholarships/{id}', [ScholarshipController::class, 'update'])->name('scholarships.update');
        Route::delete('/scholarships/{id}', [ScholarshipController::class, 'destroy'])->name('scholarships.destroy');
    });
});

require __DIR__ . '/auth.php';

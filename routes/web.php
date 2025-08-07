<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recruiter\JobController as RecruiterJobController;
use App\Http\Controllers\JobSeeker\JobBrowseController;
use App\Http\Controllers\JobSeeker\ApplicationController;
use App\Http\Controllers\Recruiter\ApplicationController as RecruiterApplicationController;
use App\Http\Controllers\JobSeeker\ResumeController;
use App\Http\Controllers\JobSeeker\DashboardController;
use App\Http\Controllers\Admin\AdminReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ROLE-BASED DASHBOARDS ---
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->name('admin.dashboard');

Route::middleware(['auth', 'role:recruiter'])->get('/recruiter/dashboard', function () {
    return view('dashboards.recruiter');
})->name('recruiter.dashboard');

Route::get('/job-seeker/dashboard', [DashboardController::class, 'index']) // <-- THIS IS THE REPLACED ROUTE
    ->middleware(['auth', 'role:job_seeker'])
    ->name('jobseeker.dashboard');

Route::middleware(['auth', 'role:support'])->get('/support/dashboard', function () {
    return view('dashboards.support');
})->name('support.dashboard');

// --- ROLE-SPECIFIC ROUTE GROUPS ---

// routes/web.php
// ✅ Admin Report Page
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
});

Route::get('/admin/reports/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPDF'])
    ->name('admin.reports.pdf')
    ->middleware(['auth', 'role:admin']);





// 👔 Recruiter Routes
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::resource('jobs', RecruiterJobController::class);

    // ✅ View applications submitted to recruiter's jobs
    Route::get('applications', [RecruiterApplicationController::class, 'index'])->name('applications.index');
});


// 👨‍💼 Job Seeker Routes
Route::middleware(['auth', 'role:job_seeker'])->prefix('job-seeker')->name('jobseeker.')->group(function () {
    // View jobs
    Route::get('jobs', [JobBrowseController::class, 'index'])->name('jobs.index');
    Route::get('jobs/{job}', [JobBrowseController::class, 'show'])->name('jobs.show');

    // Apply to jobs
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('applications', [ApplicationController::class, 'store'])->name('applications.store');

    // Resume form & save
    Route::get('resume/create', [\App\Http\Controllers\JobSeeker\ResumeController::class, 'create'])->name('resume.create');
    Route::post('resume', [\App\Http\Controllers\JobSeeker\ResumeController::class, 'store'])->name('resume.store');
    Route::get('resume/{resume}/download', [ResumeController::class, 'download'])->name('resume.download');
    Route::get('resume/{resume}', [ResumeController::class, 'show'])->name('resume.show');

    Route::resource('resume', \App\Http\Controllers\JobSeeker\ResumeController::class)->except(['show']);
    Route::get('resume/{resume}/download', [\App\Http\Controllers\JobSeeker\ResumeController::class, 'download'])->name('resume.download');

    Route::get('/job-seeker/resumes', [ResumeController::class, 'list'])->name('jobseeker.resumes.index');

});


require __DIR__ . '/auth.php';

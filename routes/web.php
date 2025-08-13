<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recruiter\JobController as RecruiterJobController;
use App\Http\Controllers\JobSeeker\JobBrowseController;
use App\Http\Controllers\JobSeeker\ApplicationController;
use App\Http\Controllers\Recruiter\ApplicationController as RecruiterApplicationController;
use App\Http\Controllers\JobSeeker\ResumeController;
use App\Http\Controllers\JobSeeker\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\JobSeeker\RecommendationController;
use App\Http\Controllers\JobSeeker\SkillController as SkillProfileController;
use App\Http\Controllers\JobSeeker\SkillController;
use App\Http\Controllers\Recruiter\JobSkillController;
use App\Http\Controllers\JobSeeker\SkillGapController;


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

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports/advanced', [ReportController::class, 'advanced'])->name('reports.advanced');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});


Route::get('/admin/reports/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPDF'])
    ->name('admin.reports.pdf')
    ->middleware(['auth', 'role:admin']);


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports'); // your existing page
    Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.exportCsv'); // new
});
use App\Http\Controllers\Admin\CourseController;

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('courses', CourseController::class); // index, create, store, edit, update, destroy
});





// 👔 Recruiter Routes

Route::get('jobs/{job}/skills', [JobSkillController::class, 'edit'])->name('jobs.skills.edit');
Route::post('jobs/{job}/skills', [JobSkillController::class, 'update'])->name('jobs.skills.update');

Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::resource('jobs', RecruiterJobController::class);

    // ✅ View applications submitted to recruiter's jobs
    Route::get('applications', [RecruiterApplicationController::class, 'index'])->name('applications.index');
});

// inside recruiter group...
Route::middleware(['auth','role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::resource('jobs', \App\Http\Controllers\Recruiter\JobController::class);
});


// 👨‍💼 Job Seeker Routes



Route::middleware(['auth','role:job_seeker'])
    ->prefix('job-seeker')
    ->name('jobseeker.')
    ->group(function () {
        Route::get('skills', [SkillController::class, 'edit'])->name('skills.edit');
        Route::post('skills', [SkillController::class, 'update'])->name('skills.update');

        Route::get('skill-gap/{job}', [SkillGapController::class, 'show'])->name('skillgap.show');
        Route::post('courses/{course}/enroll', [SkillGapController::class, 'enroll'])->name('courses.enroll');
    });

Route::middleware(['auth','role:job_seeker'])
    ->prefix('job-seeker')
    ->name('jobseeker.')
    ->group(function () {
        Route::post('skills', [SkillProfileController::class, 'store'])->name('skills.store');
    });

Route::middleware(['auth','role:job_seeker'])->prefix('job-seeker')->name('jobseeker.')->group(function () {
    Route::get('jobs/{job}/skill-gap', [\App\Http\Controllers\JobSeeker\SkillGapController::class, 'show'])->name('jobs.skill-gap');
});


Route::middleware(['auth','role:job_seeker'])->prefix('job-seeker')->name('jobseeker.')->group(function () {
    // existing job browse & applications...
    Route::get('skills', [\App\Http\Controllers\JobSeeker\SkillController::class, 'edit'])->name('skills.edit');
    Route::post('skills', [\App\Http\Controllers\JobSeeker\SkillController::class, 'update'])->name('skills.update');
});

Route::middleware(['auth','role:job_seeker'])->prefix('job-seeker')->name('jobseeker.')->group(function () {
    Route::get('recommendations', [RecommendationController::class,'index'])->name('recommendations.index');
    Route::get('recommendations/job/{job}', [RecommendationController::class,'forJob'])->name('recommendations.forJob');
    Route::post('courses/{course}/enroll', [RecommendationController::class,'enroll'])->name('courses.enroll');
});

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

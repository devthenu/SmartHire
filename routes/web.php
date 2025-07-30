<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// --- START: ADDED ROLE-SPECIFIC DASHBOARD ROUTES ---

// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->name('admin.dashboard'); // Added name for easier referencing

// Recruiter Dashboard
Route::middleware(['auth', 'role:recruiter'])->get('/recruiter/dashboard', function () {
    return view('dashboards.recruiter');
})->name('recruiter.dashboard'); // Added name

// Job Seeker Dashboard
Route::middleware(['auth', 'role:job_seeker'])->get('/job-seeker/dashboard', function () {
    return view('dashboards.jobseeker');
})->name('jobseeker.dashboard'); // Added name

// Support Dashboard
Route::middleware(['auth', 'role:support'])->get('/support/dashboard', function () {
    return view('dashboards.support');
})->name('support.dashboard'); // Added name

// --- END: ADDED ROLE-SPECIFIC DASHBOARD ROUTES ---

require __DIR__.'/auth.php';

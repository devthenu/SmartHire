<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Store a newly created job application.
     */
    public function store(Request $request)
    {
        // Validate the job_id exists
        $request->validate([
            'job_id' => 'required|exists:jobs,id'
        ]);

        // Get the job model
        $job = Job::findOrFail($request->job_id);

        // ✅ Using Auth::id() - IDE will recognize this
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', '❌ You have already applied to this job.');
        }

        // ✅ Create application using Auth::id()
        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $request->job_id,
            'status' => 'pending',
        ]);

        return back()->with('success', '✅ Application submitted successfully!');
    }

    /**
     * List user's applications
     */
    public function index()
    {
        $applications = Application::with('job.company')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('jobseeker.applications.index', compact('applications'));
    }
}
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
    public function store(Request $request, Job $job)
    {
        $user = Auth::user(); // 👤 Currently authenticated user

        // 🔒 Prevent duplicate applications
        if (
            Application::where('user_id', $user->id)
                ->where('job_id', $job->id)
                ->exists()
        ) {
            return back()->with('error', '❌ You have already applied for this job.');
        }

        // ✅ Create new application
        Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => 'applied', // You could default this in your DB too
        ]);

        return back()->with('success', '✅ Application submitted successfully!');
    }

    /**
     * Optional: Show user's applications
     */
    public function index()
    {
        $applications = Application::with('job')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('jobseeker.applications.index', compact('applications'));
    }
}

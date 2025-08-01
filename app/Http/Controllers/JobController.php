<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // 📄 Show list of all jobs for job seekers
    public function index()
    {
        $jobs = Job::latest()->paginate(10); // Get recent jobs paginated
        return view('jobseeker.jobs.index', compact('jobs'));
    }

    // 📄 Show single job details
    public function show(Job $job)
    {
        return view('jobseeker.jobs.show', compact('job'));
    }
}

<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobBrowseController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->paginate(10); // Fetch latest jobs

        return view('jobseeker.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        return view('jobseeker.jobs.show', compact('job'));
    }
}

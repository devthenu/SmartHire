<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        // Get applications for recruiter's jobs
        $applications = Application::with(['job', 'user'])
            ->whereHas('job', function ($query) {
                $query->where('user_id', Auth::id()); // recruiter ID
            })
            ->latest()
            ->get();

        return view('recruiter.applications.index', compact('applications'));
    }
}


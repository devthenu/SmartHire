<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $resumes = Auth::user()->resumes()->with('resumeTemplate')->get();

        return view('dashboards.jobseeker', compact('resumes'));
    }
}

<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function create()
    {
        $templates = ResumeTemplate::all(); // Load templates
        return view('jobseeker.resume.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'education' => 'required|string',
            'experience' => 'required|string',
            'skills' => 'required|string',
            'resume_template_id' => 'required|exists:resume_templates,id',
        ]);

        $validated['user_id'] = Auth::id();

        Resume::create($validated);

        return redirect()->route('jobseeker.dashboard')->with('success', '✅ Resume saved successfully!');
    }
}

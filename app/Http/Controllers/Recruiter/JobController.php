<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Company;
use App\Models\Skill; // <-- ADDED: Import the Skill model
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('user_id', Auth::id())->latest()->paginate(10);
        return view('recruiter.jobs.index', compact('jobs'));
    }

    public function create()
    {
        // <-- MODIFIED: Fetch all skills to populate a dropdown/checkbox list in the form
        $skills = Skill::orderBy('name')->get();
        return view('recruiter.jobs.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'location' => 'required|string|max:255',
            'type' => 'required|in:full-time,part-time,contract',
            'salary' => 'nullable|numeric',
            'deadline' => 'required|date|after:today',
            'skills' => 'array',        // <-- ADDED: Validate that 'skills' is an array
            'skills.*' => 'exists:skills,id', // <-- ADDED: Validate each skill ID exists in the 'skills' table
        ]);

        $validated['user_id'] = Auth::id();
        $validated['company_id'] = Company::where('user_id', Auth::id())->value('id');

        $job = Job::create($validated); // <-- MODIFIED: Capture the created job instance

        // <-- ADDED: Sync the selected skills with the job
        // sync() handles attaching and detaching relationships
        $job->skills()->sync($request->input('skills', []));

        return redirect()->route('recruiter.jobs.index')->with('success', '✅ Job created successfully.');
    }

    public function edit(Job $job)
    {
        //$this->authorize('update', $job); // optional policy

        // <-- MODIFIED: Fetch all skills and load the job's currently associated skills
        $skills = Skill::orderBy('name')->get();
        $job->load('skills'); // Eager load the skills associated with this job

        return view('recruiter.jobs.edit', compact('job', 'skills'));
    }

    public function update(Request $request, Job $job)
    {
        //$this->authorize('update', $job); // optional policy

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'location' => 'required|string|max:255',
            'type' => 'required|in:full-time,part-time,contract',
            'salary' => 'nullable|numeric',
            'deadline' => 'required|date|after:today',
            'skills' => 'array',        // <-- ADDED: Validate that 'skills' is an array
            'skills.*' => 'exists:skills,id', // <-- ADDED: Validate each skill ID exists
        ]);

        $job->update($validated);

        // <-- ADDED: Sync the selected skills with the job
        $job->skills()->sync($request->input('skills', []));

        return redirect()->route('recruiter.jobs.index')->with('success', '✅ Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        //$this->authorize('delete', $job); // optional policy

        $job->delete();

        return redirect()->route('recruiter.jobs.index')->with('success', '🗑️ Job deleted.');
    }
}
<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Company;
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
        return view('recruiter.jobs.create');
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
        ]);

        $validated['user_id'] = Auth::id();
        $validated['company_id'] = Company::where('user_id', Auth::id())->value('id');

        Job::create($validated);

        return redirect()->route('recruiter.jobs.index')->with('success', '✅ Job created successfully.');

    }

    public function edit(Job $job)
    {
        //$this->authorize('update', $job); // optional policy
        return view('recruiter.jobs.edit', compact('job'));
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
        ]);

        $job->update($validated);

        return redirect()->route('recruiter.jobs.index')->with('success', '✅ Job updated successfully.');


    }

    public function destroy(Job $job)
    {
        //$this->authorize('delete', $job); // optional policy

        $job->delete();

        return redirect()->route('recruiter.jobs.index')->with('success', '🗑️ Job deleted.');
    }
}

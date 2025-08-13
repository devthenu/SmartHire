<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSkillController extends Controller
{
    public function edit(Job $job)
    {
        // ensure this job belongs to the recruiter
        if ($job->user_id !== Auth::id()) abort(403);

        $allSkills = Skill::orderBy('name')->get(['id','name']);
        $current = $job->skills()->pluck('skills.id')->toArray(); // assuming Job has belongsToMany(Skill::class,'job_skills')

        return view('recruiter.jobs.skills', compact('job','allSkills','current'));
    }

    public function update(Request $request, Job $job)
    {
        if ($job->user_id !== Auth::id()) abort(403);

        $data = $request->validate([
            'skills' => ['nullable','array'],
            'skills.*' => ['integer','exists:skills,id'],
        ]);

        $job->skills()->sync($data['skills'] ?? []);
        return redirect()->route('recruiter.jobs.index')->with('success','✅ Job skills updated.');
    }
}

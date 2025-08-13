<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    // GET /job-seeker/skills
    public function edit()
    {
        $userId = Auth::id();

        // All available skills for dropdowns
        $allSkills = Skill::orderBy('name')->get(['id','name']);

        // User’s existing skills with proficiency
        $userSkills = UserSkill::with('skill:id,name')
            ->where('user_id', $userId)
            ->get();

        // Map to a simple array the Blade can iterate
        $userSkillsWithProficiency = $userSkills->map(function ($us) {
            return [
                'skill_id' => $us->skill_id,
                'skill_name' => optional($us->skill)->name,
                'level' => $us->proficiency_level,
            ];
        });

        return view('jobseeker.skills.edit', compact('allSkills', 'userSkillsWithProficiency'));
    }

    // POST /job-seeker/skills
    public function update(Request $request)
    {
        $request->validate([
            'skills'      => ['required','array','min:1'],
            'skills.*'    => ['integer','exists:skills,id'],
            'levels'      => ['nullable','array'],
            'levels.*'    => ['nullable','in:beginner,intermediate,advanced,expert'],
        ]);

        $skills = $request->input('skills', []);
        $levels = $request->input('levels', []);

        foreach ($skills as $idx => $skillId) {
            $level = $levels[$idx] ?? 'beginner'; // default if missing
            UserSkill::updateOrCreate(
                ['user_id' => Auth::id(), 'skill_id' => $skillId],
                ['proficiency_level' => $level]
            );
        }

        // (Optional) remove skills that were previously saved but not sent this time:
        $keepIds = collect($skills)->map(fn($id)=> (int)$id)->all();
        UserSkill::where('user_id', Auth::id())
            ->whereNotIn('skill_id', $keepIds)
            ->delete();

        return back()->with('success', '✅ Skills updated successfully.');
    }
}

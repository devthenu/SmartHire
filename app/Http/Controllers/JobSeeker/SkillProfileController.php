<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillProfileController extends Controller
{
    public function store(Request $request)
    {
        // Validate: skills[] and levels[] (levels optional -> fallback to 'beginner')
        $request->validate([
            'skills'      => ['required', 'array', 'min:1'],
            'skills.*'    => ['integer', 'exists:skills,id'],
            'levels'      => ['nullable', 'array'],
            'levels.*'    => ['nullable', 'in:beginner,intermediate,advanced,expert'],
        ]);

        $skills  = $request->input('skills', []);
        $levels  = $request->input('levels', []); // could be missing or shorter

        foreach ($skills as $idx => $skillId) {
            $level = $levels[$idx] ?? 'beginner'; // ✅ default if not provided

            UserSkill::updateOrCreate(
                ['user_id' => Auth::id(), 'skill_id' => $skillId],
                ['proficiency_level' => $level]
            );
        }

        return back()->with('success', 'Skills saved!');
    }
}

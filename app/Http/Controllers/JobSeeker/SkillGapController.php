<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Skill;
use App\Models\TrainingCourse;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;

class SkillGapController extends Controller
{
    /**
     * Show skill gap for a given job and recommend courses.
     */
    public function show(Job $job)
    {
        $user = Auth::user();

        // Pull skill IDs via pivot (no extra queries later)
        $jobSkillIds  = $job->skills()->pluck('skills.id');
        $userSkillIds = $user->skills()->pluck('skills.id');

        // Missing skills are the job skills the user doesn't have
        $missingSkills = Skill::whereIn('id', $jobSkillIds->diff($userSkillIds))
            ->orderBy('name')
            ->get();

        // Build a lowercase list of missing skill names to match against courses
        $missingNames = $missingSkills->pluck('name')
            ->map(fn ($n) => trim(mb_strtolower($n)))
            ->filter()
            ->unique()
            ->values();

        // Recommend courses by matching ANY missing skill name inside `skills_covered`
        // (Assumes `skills_covered` is a TEXT/VARCHAR column with comma/space-separated names)
        $recommendedCourses = collect();
        if ($missingNames->isNotEmpty()) {
            $recommendedCourses = TrainingCourse::query()
                ->where(function ($q) use ($missingNames) {
                    foreach ($missingNames as $name) {
                        // PostgreSQL case-insensitive match
                        $q->orWhere('skills_covered', 'ILIKE', "%{$name}%");
                    }
                })
                ->orderBy('price') // tweak sort as you like
                ->limit(12)
                ->get();
        }

        return view('jobseeker.skills.gap', [
            'job'                => $job,
            'missingSkills'      => $missingSkills,
            'recommendedCourses' => $recommendedCourses,
        ]);
    }

    /**
     * Enroll current user into a training course (idempotent).
     */
    public function enroll(TrainingCourse $course)
    {
        CourseEnrollment::firstOrCreate(
            [
                'user_id'            => Auth::id(),
                'training_course_id' => $course->id,
            ],
            [
                'completion_status'  => 'enrolled',
                'enrolled_at'        => now(),
            ]
        );

        return back()->with('success', '✅ Enrolled in course.');
    }
}

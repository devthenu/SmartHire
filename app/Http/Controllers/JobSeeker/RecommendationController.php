<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Skill;
use App\Models\TrainingCourse;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index()
    {
        // Generic: just show recent courses if no job is selected
        $courses = TrainingCourse::latest()->take(10)->get();

        return view('jobseeker.recommendations.index', [
            'courses' => $courses,
            'missingSkills' => [],
            'context' => 'General recommendations'
        ]);
    }

    public function forJob(Job $job)
    {
        $userId = Auth::id();

        // User skills -> lowercased names
        $userSkills = Skill::select('skills.name')
            ->join('user_skills','skills.id','=','user_skills.skill_id')
            ->where('user_skills.user_id',$userId)
            ->pluck('name')
            ->map(fn($n) => mb_strtolower($n))
            ->values();

        // Job required skills -> lowercased names
        $jobSkills = Skill::select('skills.name')
            ->join('job_skills','skills.id','=','job_skills.skill_id')
            ->where('job_skills.job_id',$job->id)
            ->pluck('name')
            ->map(fn($n) => mb_strtolower($n))
            ->values();

        // Missing = required - current
        $missing = $jobSkills->diff($userSkills)->values();

        // Recommend courses with overlap to missing skills
        $courses = TrainingCourse::get()->filter(function($c) use ($missing) {
            $covered = collect($c->skills_covered ?? [])->map(fn($n) => mb_strtolower($n));
            return $covered->intersect($missing)->isNotEmpty();
        })->values();

        return view('jobseeker.recommendations.index', [
            'courses' => $courses,
            'missingSkills' => $missing,
            'context' => "Recommendations for job: {$job->title}",
            'job' => $job,
        ]);
    }

    public function enroll(TrainingCourse $course)
    {
        CourseEnrollment::firstOrCreate([
            'user_id' => Auth::id(),
            'training_course_id' => $course->id,
        ], [
            'completion_status' => 'enrolled',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Enrolled in course!');
    }
}

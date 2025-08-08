<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingCourse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = TrainingCourse::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:1024'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'skills_covered' => ['nullable', 'string'], // we'll convert to array
        ]);

        // Convert "Laravel, PHP, MVC" => ['Laravel','PHP','MVC']
        $skills = array_filter(array_map('trim', explode(',', $data['skills_covered'] ?? '')));
        $data['skills_covered'] = $skills; // model will cast to JSON

        \App\Models\TrainingCourse::create($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', '✅ Course created.');
    }


    public function edit(TrainingCourse $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, TrainingCourse $course)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:1024'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'skills_covered' => ['nullable', 'string'],
        ]);

        $skills = array_filter(array_map('trim', explode(',', $data['skills_covered'] ?? '')));
        $data['skills_covered'] = $skills;

        $course->update($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', '✅ Course updated.');
    }


    public function destroy(TrainingCourse $course)
    {
        $course->delete();
        return back()->with('success', 'Course deleted.');
    }

    private function parseSkills(string $csv): array
    {
        return collect(explode(',', $csv))
            ->map(fn($s) => trim($s))
            ->filter()
            ->values()
            ->toArray();
    }
}

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Edit Resume</h2>

    <form method="POST" action="{{ route('jobseeker.resume.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block font-semibold">Title</label>
                <input name="title" value="{{ old('title', $resume->title ?? '') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none" required>
            </div>

            <div>
                <label class="block font-semibold">Template</label>
                <select name="resume_template_id" class="w-full border rounded px-3 py-2">
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}"
                            {{ (old('resume_template_id', $resume->resume_template_id ?? '') == $template->id) ? 'selected' : '' }}>
                            {{ $template->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold">Education</label>
                <input name="education" value="{{ old('education', $resume->education ?? '') }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold">Experience</label>
                <input name="experience" value="{{ old('experience', $resume->experience ?? '') }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold">Skills</label>
                <input name="skills" value="{{ old('skills', $resume->skills ?? '') }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    💾 Save Resume
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

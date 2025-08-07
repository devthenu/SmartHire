@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8"> {{-- Added padding for better spacing --}}
    <h2 class="text-3xl font-bold text-gray-800 mb-6">📝 Build Your Resume</h2>

    <form method="POST" action="{{ route('jobseeker.resume.store') }}">
        @csrf

        {{-- The new form body starts here --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-lg shadow-md"> {{-- Increased gap and added card styling --}}

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Resume Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $resume->title ?? '') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="resume_template_id" class="block text-sm font-semibold text-gray-700 mb-1">Select Template</label>
                <select name="resume_template_id" id="resume_template_id" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}"
                            {{ (old('resume_template_id', $resume->resume_template_id ?? '') == $template->id) ? 'selected' : '' }}>
                            {{ $template->name }}
                        </option>
                    @endforeach
                </select>
                @error('resume_template_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="education" class="block text-sm font-semibold text-gray-700 mb-1">Education</label>
                <textarea name="education" id="education" rows="4"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ old('education', $resume->education ?? '') }}</textarea>
                @error('education')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="experience" class="block text-sm font-semibold text-gray-700 mb-1">Experience</label>
                <textarea name="experience" id="experience" rows="6"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ old('experience', $resume->experience ?? '') }}</textarea>
                @error('experience')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="skills" class="block text-sm font-semibold text-gray-700 mb-1">Skills (comma separated)</label>
                <input type="text" name="skills" id="skills" value="{{ old('skills', $resume->skills ?? '') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('skills')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2 mt-4">
                <button type="submit"
                    class="w-full inline-flex justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    💾 Save Resume
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
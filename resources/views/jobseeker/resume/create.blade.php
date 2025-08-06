@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">📝 Build Your Resume</h2>
    

    <form action="{{ route('jobseeker.resume.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Resume Title</label>
            <input name="title" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Education</label>
            <textarea name="education" class="w-full border rounded px-3 py-2" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Experience</label>
            <textarea name="experience" class="w-full border rounded px-3 py-2" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Skills (comma separated)</label>
            <input name="skills" class="w-full border rounded px-3 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block font-medium">Select Resume Template</label>
            <select name="resume_template_id" class="w-full border rounded px-3 py-2" required>
                @foreach ($templates as $template)
                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                @endforeach
            </select>
            
        </div>
        

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Resume
        </button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Your Resume Preview</h1>

    <div class="bg-white p-6 shadow rounded">
        <p><strong>Title:</strong> {{ $resume->title }}</p>
        <p><strong>Education:</strong> {{ is_array($resume->education) ? implode(', ', $resume->education) : $resume->education }}</p>
        <p><strong>Experience:</strong> {{ is_array($resume->experience) ? implode(', ', $resume->experience) : $resume->experience }}</p>
        <p><strong>Skills:</strong> {{ is_array($resume->skills) ? implode(', ', $resume->skills) : $resume->skills }}</p>
        <p><strong>Template:</strong> {{ $resume->resumeTemplate->name ?? 'N/A' }}</p>

        <a href="{{ route('jobseeker.resume.download', $resume->id) }}" class="btn btn-primary">
            📥 Download Resume PDF
        </a>

    </div>
</div>
@endsection

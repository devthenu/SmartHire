@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h2 class="text-xl font-semibold mb-4">
        Skill Gap for: {{ $job->title }}
    </h2>

    @if($missingSkills->isEmpty())
        <div class="alert alert-success">🎉 You already match all listed skills for this job.</div>
    @else
        <div class="mb-4">
            <h3 class="font-semibold">Missing Skills</h3>
            <ul class="list-disc ms-6">
                @foreach($missingSkills as $skill)
                    <li>{{ ucfirst($skill) }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold mb-2">Recommended Courses</h3>

            @forelse($courses as $course)
                <div class="border rounded p-4 mb-3 bg-white shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold">{{ $course->title }}</h4>
                            <p class="text-sm text-gray-600">Provider: {{ $course->provider }}</p>
                            <p class="text-sm mt-2">{{ Str::limit($course->description, 160) }}</p>
                            <p class="text-sm mt-1">
                                <strong>Skills:</strong>
                                @if(is_array($course->skills_covered))
                                    {{ implode(', ', $course->skills_covered) }}
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            @if(!is_null($course->price))
                                <div class="font-bold">LKR {{ number_format($course->price, 2) }}</div>
                            @endif
                            @if($course->url)
                                <a href="{{ $course->url }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                    View Course
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No matching courses yet. Check back later.</p>
            @endforelse
        </div>
    @endif
</div>
@endsection

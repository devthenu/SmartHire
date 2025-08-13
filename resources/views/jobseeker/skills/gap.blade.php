@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;

    // 🔒 Backward-compatible defaults
    $missingSkills = $missingSkills ?? collect();
    $recommended   = $recommended   ?? collect();
@endphp

<div class="max-w-4xl mx-auto p-6">
  <h2 class="text-xl font-semibold mb-4">Skill Gap for: {{ $job->title }}</h2>

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
  @endif

  <div class="mb-6">
    <h3 class="font-semibold mb-2">Missing Skills</h3>
    @if($missingSkills->isEmpty())
      <p class="text-green-700">🎉 You already match all required skills for this job.</p>
    @else
      <ul class="list-disc pl-6">
        @foreach($missingSkills as $ms)
          <li>{{ $ms->name }}</li>
        @endforeach
      </ul>
    @endif
  </div>

  <div>
    <h3 class="font-semibold mb-2">Recommended Courses</h3>
    @if($recommended->isEmpty())
      <p class="text-gray-600">No matching courses found yet.</p>
    @else
      <div class="grid md:grid-cols-2 gap-4">
        @foreach($recommended as $course)
          <div class="border rounded p-4 bg-white">
            <h4 class="font-semibold">{{ $course->title }}</h4>
            <p class="text-sm text-gray-600 mb-2">
              {{ $course->provider }}
              @if(!is_null($course->price))
                • ${{ number_format((float)$course->price, 2) }}
              @endif
            </p>
            @if(!empty($course->description))
              <p class="text-sm mb-3">{{ Str::limit($course->description, 140) }}</p>
            @endif

            <div class="flex items-center gap-2">
              @if(!empty($course->url))
                <a href="{{ $course->url }}" target="_blank"
                   class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-sm">
                   View
                </a>
              @endif

              <form method="POST" action="{{ route('jobseeker.courses.enroll', $course->id) }}">
                  @csrf
                  <button class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Enroll</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection

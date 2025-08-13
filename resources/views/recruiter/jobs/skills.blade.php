@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
  <h2 class="text-xl font-semibold mb-4">Required Skills for: {{ $job->title }}</h2>

  <form method="POST" action="{{ route('recruiter.jobs.skills.update', $job) }}">
    @csrf

    <div id="skills-wrapper">
      @foreach($allSkills as $skill)
        <label class="flex items-center gap-2 mb-2">
          <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                 @checked(in_array($skill->id, $current))>
          <span>{{ $skill->name }}</span>
        </label>
      @endforeach
    </div>

    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Save</button>
  </form>
</div>
@endsection

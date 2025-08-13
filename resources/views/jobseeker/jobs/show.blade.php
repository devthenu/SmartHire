@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $job->title }}</h2>
    <p><strong>Company:</strong> {{ $job->company->name ?? 'N/A' }}</p>
    <p><strong>Location:</strong> {{ $job->location }}</p>
    <p><strong>Type:</strong> {{ $job->type }}</p>
    <p><strong>Salary:</strong> ₹{{ number_format($job->salary) }}</p>
    <p><strong>Deadline:</strong> {{ $job->deadline->format('d M Y') }}</p>

    <hr>
    <p>{!! nl2br(e($job->description)) !!}</p>

    {{-- Action buttons section --}}
    <div class="d-flex gap-3 mb-3">
        @if (!auth()->user()->applications->contains('job_id', $job->id))
            <form action="{{ route('jobseeker.applications.store') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <button type="submit" class="btn btn-primary">Apply Now</button>
            </form>
        @else
            <span class="text-muted">✅ Already Applied</span>
        @endif

        {{-- Skill Gap Analysis Link --}}
        <a href="{{ route('jobseeker.skillgap.show', $job) }}" class="btn btn-outline-secondary">
            🔍 Check Skill Gap
        </a>
    </div>

    {{-- Optional: Show required skills for better visibility --}}
    @if($job->skills && $job->skills->count())
        <div class="mb-4">
            <h5 class="font-weight-bold mb-2">Required Skills:</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($job->skills as $skill)
                    <span class="badge badge-secondary">{{ $skill->name }}</span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Back to jobs list --}}
    <div class="mt-3">
        <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-secondary">← Back to Jobs</a>
    </div>
</div>
@endsection
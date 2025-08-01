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

    @if (!auth()->user()->applications->contains('job_id', $job->id))
        <form action="{{ route('jobseeker.applications.store') }}" method="POST">
            @csrf
            <input type="hidden" name="job_id" value="{{ $job->id }}">
            <button type="submit" class="btn btn-primary">Apply Now</button>
        </form>
    @else
        <p class="text-muted">✅ Already Applied</p>
    @endif

    {{-- Back to jobs list --}}
    <div class="mt-3">
        <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-secondary">← Back to Jobs</a>
    </div>
</div>
@endsection
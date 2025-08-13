@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Available Jobs</h2>

    @foreach($jobs as $job)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $job->title }}</h5>
                <p>{{ Str::limit($job->description, 100) }}</p>
                <p><strong>Location:</strong> {{ $job->location }}</p>
                
                {{-- Action buttons --}}
                <div class="d-flex gap-3 align-items-center">
                    <a href="{{ route('jobseeker.jobs.show', $job->id) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('jobseeker.skillgap.show', $job) }}" class="btn btn-outline-info btn-sm">
                        🔍 Skill Gap
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    {{ $jobs->links() }}
</div>
@endsection
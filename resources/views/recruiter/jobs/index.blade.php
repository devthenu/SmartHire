@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Posted Jobs</h2>
    <a href="{{ route('recruiter.jobs.create') }}" class="btn btn-primary mb-3">+ Post New Job</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr><th>Title</th><th>Type</th><th>Location</th><th>Deadline</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @foreach($jobs as $job)
            <tr>
                <td>{{ $job->title }}</td>
                <td>{{ ucfirst($job->type) }}</td>
                <td>{{ $job->location }}</td>
                <td>{{ $job->deadline->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('recruiter.jobs.edit', $job) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('recruiter.jobs.destroy', $job) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this job?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $jobs->links() }}
</div>
@endsection

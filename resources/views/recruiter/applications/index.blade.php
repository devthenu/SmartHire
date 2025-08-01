@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📥 Applications for Your Jobs</h2>

    @if ($applications->isEmpty())
        <p>No applications yet.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Applicant</th>
                    <th>Status</th>
                    <th>Applied At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->user->name }}</td>
                        <td>{{ ucfirst($application->status) }}</td>
                        <td>{{ $application->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

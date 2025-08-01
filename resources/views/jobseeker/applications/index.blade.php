@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">📄 Your Applications</h2>

        @if($applications->isEmpty())
            <p>You haven't applied to any jobs yet.</p>
        @else
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Job Title</th>
                        <th class="px-4 py-2">Company</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Applied On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                        <tr>
                            <td class="border px-4 py-2">{{ $app->job->title }}</td>
                            <td class="border px-4 py-2">{{ $app->job->company->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($app->status) }}</td>
                            <td class="border px-4 py-2">{{ $app->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

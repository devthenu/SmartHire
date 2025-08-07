@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">📄 My Resumes</h1>

    @forelse($resumes as $resume)
        <div class="mb-6 border p-4 rounded-md bg-white shadow">
            <h3 class="text-lg font-semibold">{{ $resume->title ?? 'Untitled Resume' }}</h3>
            <p><strong>Template:</strong> {{ $resume->resumeTemplate->name ?? 'N/A' }}</p>
            <p><strong>Created:</strong> {{ $resume->created_at->format('Y-m-d') }}</p>

            @if($resume->cv_pdf_path)
                <a href="{{ asset('storage/' . $resume->cv_pdf_path) }}" target="_blank"
                    class="inline-block mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    📥 View Resume PDF
                </a>
            @else
                <p class="text-sm text-gray-500 mt-2">❌ No PDF yet. Please generate it.</p>
            @endif
        </div>
    @empty
        <p class="text-gray-600">You haven’t created any resumes yet.</p>
    @endforelse
</div>
@endsection

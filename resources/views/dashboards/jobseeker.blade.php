@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Job Seeker Dashboard</h2>
            <a href="{{ route('jobseeker.resume.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create New Resume
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @forelse($resumes as $resume)
            <div class="bg-white shadow-lg rounded-lg p-6 mb-4 border border-gray-200 hover:border-indigo-500 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $resume->title ?? 'Untitled Resume' }}</h3>
                        <p class="text-sm text-gray-600">
                            Template: <span class="font-medium">{{ $resume->resumeTemplate->name ?? 'N/A' }}</span>
                        </p>
                        <p class="text-sm text-gray-500">
                            Created: <span class="font-medium">{{ $resume->created_at->format('Y-m-d') }}</span>
                        </p>
                    </div>

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('jobseeker.resume.edit', $resume->id) }}" class="p-2 text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>
                        <form action="{{ route('jobseeker.resume.destroy', $resume->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this resume?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:text-red-800 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap gap-3">
                    @if($resume->cv_pdf_path)
                        <a href="{{ asset('storage/' . $resume->cv_pdf_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414L14.586 5A2 2 0 0115 6.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm6 6a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75zM7 10.75a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zM7.75 13.5a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                            </svg>
                            View Saved Resume
                        </a>
                    @else
                        <span class="text-sm text-gray-500">No saved PDF available yet.</span>
                    @endif
                    <a href="{{ route('jobseeker.resume.download', $resume->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a.75.75 0 01.75.75v8.69l1.45-1.45a.75.75 0 011.06 1.06l-2.75 2.75a.75.75 0 01-1.06 0l-2.75-2.75a.75.75 0 011.06-1.06l1.45 1.45V2.75A.75.75 0 0110 2z" />
                            <path d="M3.75 12.75a.75.75 0 010-1.5h-.5a2.5 2.5 0 00-2.5 2.5v2.5a2.5 2.5 0 002.5 2.5h11.5a2.5 2.5 0 002.5-2.5v-2.5a2.5 2.5 0 00-2.5-2.5h-.5a.75.75 0 010 1.5h.5a1 1 0 011 1v2.5a1 1 0 01-1 1H3.75a1 1 0 01-1-1v-2.5a1 1 0 011-1h.5z" />
                        </svg>
                        Download New PDF
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <p class="text-lg text-gray-600">You haven’t created any resumes yet. Get started now!</p>
            </div>
        @endforelse
    </div>
@endsection
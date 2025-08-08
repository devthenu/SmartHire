@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold">🎯 Skill Recommendations</h1>
        <p class="text-gray-600">{{ $context }}</p>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border border-green-200 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(!empty($missingSkills))
        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded">
            <p class="font-semibold">Missing Skills:</p>
            <div class="mt-2">
                @foreach($missingSkills as $s)
                    <span class="inline-block text-xs bg-yellow-200 px-2 py-1 rounded mr-1">{{ $s }}</span>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-4">
        @forelse($courses as $c)
        <div class="border rounded p-4 bg-white">
            <h3 class="text-lg font-semibold">{{ $c->title }}</h3>
            <p class="text-sm text-gray-600">{{ $c->provider }} @if($c->price) — Rs {{ number_format($c->price,2) }} @else — Free @endif</p>
            <p class="mt-2 text-sm">{{ $c->description }}</p>
            <div class="mt-2">
                @foreach(($c->skills_covered ?? []) as $s)
                    <span class="inline-block text-xs bg-gray-200 px-2 py-1 rounded mr-1">{{ $s }}</span>
                @endforeach
            </div>
            <div class="mt-3 flex gap-2">
                @if($c->url)
                    <a href="{{ $c->url }}" target="_blank" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">View</a>
                @endif
                <form method="POST" action="{{ route('jobseeker.courses.enroll', $c) }}">
                    @csrf
                    <button class="px-3 py-1 bg-green-600 text-white rounded text-sm">Enroll</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-gray-600">No course recommendations right now.</p>
        @endforelse
    </div>
</div>
@endsection

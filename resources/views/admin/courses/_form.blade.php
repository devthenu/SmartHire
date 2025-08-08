@php
    // If we’re editing, turn JSON skills into a CSV string; otherwise keep old() or empty.
    $skillsCsv = old('skills_covered', isset($course) ? implode(', ', $course->skills_covered ?? []) : '');
@endphp

{{-- Validation errors --}}
@if($errors->any())
    <div class="p-3 mb-3 bg-red-50 border border-red-200 text-red-700 rounded">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Title</label>
        <input name="title" value="{{ old('title', $course->title ?? '') }}" class="w-full border p-2 rounded" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Provider</label>
            <input name="provider" value="{{ old('provider', $course->provider ?? '') }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block text-sm font-medium">URL</label>
            <input name="url" type="url" value="{{ old('url', $course->url ?? '') }}" class="w-full border p-2 rounded">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium">Price (LKR)</label>
        <input name="price" type="number" step="0.01" value="{{ old('price', $course->price ?? '') }}" class="w-full border p-2 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium">Description</label>
        <textarea name="description" class="w-full border p-2 rounded" rows="3">{{ old('description', $course->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium">Skills Covered (comma-separated)</label>
        <input name="skills_covered" value="{{ $skillsCsv }}" class="w-full border p-2 rounded" placeholder="Laravel, PostgreSQL, REST">
    </div>
</div>

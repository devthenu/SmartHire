@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Course</h1>

    <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="space-y-4">
        @csrf @method('PUT')
        @include('admin.courses._form', ['course' => $course])
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </form>
</div>
@endsection

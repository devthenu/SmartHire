@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">New Course</h1>

    <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-4">
        @csrf
        @include('admin.courses._form')
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
    </form>
</div>
@endsection

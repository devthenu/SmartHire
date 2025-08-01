@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Job</h2>
    <form action="{{ route('recruiter.jobs.update', $job) }}" method="POST">
        @csrf @method('PUT')
        @include('recruiter.jobs.partials.form', ['job' => $job])
        <button class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection

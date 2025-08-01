@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Job</h2>

    {{-- Show Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>❌ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Show Success Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Job Create Form --}}
    <form action="{{ route('recruiter.jobs.store') }}" method="POST">
        @csrf
        @include('recruiter.jobs.partials.form', ['job' => null])
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
@endsection

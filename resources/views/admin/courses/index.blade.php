@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Courses</h1>
        <a href="{{ route('admin.courses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">+ New</a>
    </div>

    @if(session('success')) <div class="mb-4 text-green-700">{{ session('success') }}</div> @endif

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Title</th>
                <th class="p-2 text-left">Provider</th>
                <th class="p-2 text-left">Skills</th>
                <th class="p-2 text-right">Price</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $c)
            <tr class="border-t">
                <td class="p-2">{{ $c->title }}</td>
                <td class="p-2">{{ $c->provider }}</td>
                <td class="p-2">
                    @foreach(($c->skills_covered ?? []) as $s)
                        <span class="inline-block text-xs bg-gray-200 px-2 py-1 rounded mr-1">{{ $s }}</span>
                    @endforeach
                </td>
                <td class="p-2 text-right">{{ $c->price ? 'Rs '.number_format($c->price,2) : 'Free' }}</td>
                <td class="p-2">
                    <a href="{{ route('admin.courses.edit',$c) }}" class="text-blue-600 mr-2">Edit</a>
                    <form action="{{ route('admin.courses.destroy',$c) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Delete course?')">Del</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $courses->links() }}</div>
</div>
@endsection

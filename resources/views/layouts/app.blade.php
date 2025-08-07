<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <button
                onclick="document.documentElement.classList.toggle('dark')"
                class="fixed top-4 right-4 bg-gray-200 dark:bg-gray-800 text-sm px-4 py-2 rounded shadow"
            >
                🌓 Toggle Dark Mode
            </button>


            <main>
                @if (session('success'))
                    <div class="alert alert-success text-white p-3 rounded bg-green-600 mb-4 max-w-7xl mx-auto mt-4">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger text-white p-3 rounded bg-red-600 mb-4 max-w-7xl mx-auto mt-4">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                @yield('content')
                
            </main>
        </div>

        @stack('scripts') {{-- ✅ ADDED THIS LINE --}}
    </body>
</html>
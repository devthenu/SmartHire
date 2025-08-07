@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">📊 Admin Reports</h1>

    {{-- 📈 Job Creation --}}
    <div class="bg-white p-6 rounded shadow mb-8">
        <h2 class="text-xl font-semibold mb-4">Jobs Created (Last 6 Months)</h2>
        <canvas id="jobChart" height="300"></canvas>
    </div>

    {{-- 👤 User Registration --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">User Registrations (Last 6 Months)</h2>
        <canvas id="userChart" height="300"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const months = @json($months);
    const jobStats = @json($jobStats);
    const userStats = @json($userStats);

    new Chart(document.getElementById('jobChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Jobs Created',
                data: jobStats,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(document.getElementById('userChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Users Registered',
                data: userStats,
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SmartHire Admin Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>📊 Admin Report</h1>

    <h2>📅 Job Stats (Last 6 Months)</h2>
    <table>
        <thead><tr><th>Month</th><th>Jobs Created</th></tr></thead>
        <tbody>
            @foreach($months as $index => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ $jobStats[$index] ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>👤 User Stats (Last 6 Months)</h2>
    <table>
        <thead><tr><th>Month</th><th>Users Registered</th></tr></thead>
        <tbody>
            @foreach($months as $index => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ $userStats[$index] ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>👥 Recent Users</h2>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr></thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>💼 Recent Jobs</h2>
    <table>
        <thead><tr><th>ID</th><th>Title</th><th>Company</th><th>Created At</th></tr></thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->company->name ?? 'N/A' }}</td>
                    <td>{{ $job->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

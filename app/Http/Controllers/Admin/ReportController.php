<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FilteredReportExport;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        $months = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('Y-m');
        })->reverse();

        $jobStats = $months->mapWithKeys(function ($month) {
            return [$month => Job::whereYear('created_at', substr($month, 0, 4))
                                 ->whereMonth('created_at', substr($month, 5, 2))
                                 ->count()];
        });

        $userStats = $months->mapWithKeys(function ($month) {
            return [$month => User::whereYear('created_at', substr($month, 0, 4))
                                  ->whereMonth('created_at', substr($month, 5, 2))
                                  ->count()];
        });



        return view('admin.reports.index', [
            'months' => array_values($months->toArray()),     // 👈 fix
            'jobStats' => array_values($jobStats->toArray()), // 👈 fix
            'userStats' => array_values($userStats->toArray()) // 👈 fix
        ]);


            }

    
        // ... your existing index() here

    public function exportCsv(Request $request): StreamedResponse
    {
        // Optional filters
        $role  = $request->input('role');   // admin | recruiter | job_seeker
        $month = $request->input('month');  // YYYY-MM

        $query = User::query();

        if ($role) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        if ($month) {
            $dt = Carbon::parse($month . '-01');
            $query->whereYear('created_at', $dt->year)
                  ->whereMonth('created_at', $dt->month);
        }

        $filename = 'users_report_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, ['ID', 'Name', 'Email', 'Roles', 'Created At']);

            $query->with('roles')->orderBy('created_at', 'desc')->chunk(500, function ($users) use ($handle) {
                foreach ($users as $u) {
                    fputcsv($handle, [
                        $u->id,
                        $u->name,
                        $u->email,
                        $u->roles->pluck('name')->join('|'),
                        optional($u->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }



    public function exportPDF()
    {
        $months = collect(range(0, 5))->map(fn ($i) => now()->subMonths($i)->format('Y-m'))->reverse();

        $jobStats = $months->mapWithKeys(fn ($month) => [
            $month => Job::whereYear('created_at', substr($month, 0, 4))
                        ->whereMonth('created_at', substr($month, 5, 2))->count()
        ]);

        $userStats = $months->mapWithKeys(fn ($month) => [
            $month => User::whereYear('created_at', substr($month, 0, 4))
                        ->whereMonth('created_at', substr($month, 5, 2))->count()
        ]);

        $users = User::latest()->take(10)->get(); // latest 10 users
        $jobs = Job::latest()->take(10)->get();   // latest 10 jobs

        $pdf = Pdf::loadView('admin.reports.pdf', compact('months', 'jobStats', 'userStats', 'users', 'jobs'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('admin_report.pdf');
    }

    public function advanced(Request $request)
    {
        $role = $request->input('role');
        $month = $request->input('month');

        $query = User::query();

        if ($role) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        if ($month) {
            $query->whereMonth('created_at', Carbon::parse($month)->format('m'))
                ->whereYear('created_at', Carbon::parse($month)->format('Y'));
        }

        $users = $query->latest()->get();

        return view('admin.reports.advanced', compact('users', 'role', 'month'));
    }



        
}

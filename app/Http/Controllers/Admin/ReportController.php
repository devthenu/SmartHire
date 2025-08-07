<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;

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
}

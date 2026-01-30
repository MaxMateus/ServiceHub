<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'companiesCount' => Company::count(),
            'projectsCount'  => Project::count(),
            'ticketsCount'   => 0, 
        ];

        return Inertia::render('Dashboard', [
            'stats'         => $stats,
            'recentTickets' => [],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'companiesCount' => Company::count(),
            'projectsCount'  => 0,
            'ticketsCount'   => 0, 
        ];

        return Inertia::render('Dashboard', [
            'stats'         => $stats,
            'recentTickets' => [],
        ]);
    }
}

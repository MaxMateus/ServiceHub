<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'companiesCount' => Company::count(),
            'projectsCount'  => Project::count(),
            'ticketsCount'   => Ticket::count(),
        ];

        $recentTickets = Ticket::with(['project.company', 'assignedTo'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Ticket $ticket) {
                return [
                    'id'         => $ticket->id,
                    'title'      => $ticket->title,
                    'created_at' => $ticket->created_at->format('d/m/Y H:i'),
                    'company'    => [
                        'id'   => $ticket->project->company->id,
                        'name' => $ticket->project->company->name,
                    ],
                    'project'    => [
                        'id'   => $ticket->project->id,
                        'name' => $ticket->project->name,
                    ],
                    'assigned_to' => $ticket->assignedTo
                        ? ['id' => $ticket->assignedTo->id, 'name' => $ticket->assignedTo->name]
                        : null,
                ];
            });

        return Inertia::render('Dashboard', [
            'stats'         => $stats,
            'recentTickets' => $recentTickets,
            'companies'     => Company::select('id', 'name')->orderBy('name')->get(),
            'projects'      => Project::select('id', 'company_id', 'name')->orderBy('name')->get(),
            'users'         => User::select('id', 'name')->orderBy('name')->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\ProcessTicketAttachment;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;


class TicketController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'  => ['required', 'exists:companies,id'],
            'project_id'  => [
                'required',
                Rule::exists('projects', 'id')->where(fn ($q) => $q->where('company_id', $request->input('company_id'))),
            ],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'attachment'  => ['nullable', 'file', 'mimes:json,txt,text,plain', 'max:5120'],
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            // salva em storage/app/attachments
            $attachmentPath = $request->file('attachment')->store('attachments');
        }

        $ticket = Ticket::create([
            'project_id'      => $validated['project_id'],
            'created_by'      => $request->user()->id,
            'assigned_to'     => $validated['assigned_to'] ?? null,
            'title'           => $validated['title'],
            'description'     => $validated['description'],
            'attachment_path' => $attachmentPath,
        ]);

        TicketDetail::create([
            'ticket_id' => $ticket->id,
        ]);

        ProcessTicketAttachment::dispatch($ticket);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ticket criado com sucesso. O anexo será processado em segundo plano');
    }

    public function show(Ticket $ticket): Response
    {
        $ticket->load([
            'project.company',
            'createdBy.profile',
            'assignedTo.profile',
            'detail',
        ]);

        return Inertia::render('Tickets/Show', [
            'ticket' => [
                'id'          => $ticket->id,
                'title'       => $ticket->title,
                'description' => $ticket->description,
                'created_at'  => $ticket->created_at->format('d/m/Y H:i'),
                'attachment_path' => $ticket->attachment_path,

                'company' => [
                    'id'   => $ticket->project->company->id,
                    'name' => $ticket->project->company->name,
                ],
                'project' => [
                    'id'   => $ticket->project->id,
                    'name' => $ticket->project->name,
                ],
                'created_by' => [
                    'id'   => $ticket->createdBy->id,
                    'name' => $ticket->createdBy->name,
                ],
                'assigned_to' => $ticket->assignedTo ? [
                    'id'   => $ticket->assignedTo->id,
                    'name' => $ticket->assignedTo->name,
                ] : null,
                'detail' => $ticket->detail ? [
                    'details'      => $ticket->detail->details,
                    'processed_at' => optional($ticket->detail->processed_at)->format('d/m/Y H:i'),
                ] : null,
                'available_users' => User::select('id', 'name')->orderBy('name')->get(),
            ],
        ]);
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $ticket->update([
            'title'       => $validated['title'],
            'description' => array_key_exists('description', $validated)
                ? $validated['description']
                : $ticket->description,
            'assigned_to' => $validated['assigned_to'] ?? null,
        ]);

        return back()->with('success', 'Ticket atualizado com sucesso.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ticket excluído com sucesso.');
    }



}

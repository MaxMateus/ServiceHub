<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'  => ['required', 'exists:projects,id'],
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

        // Cria o detalhe técnico vazio: o Job vai preencher "details" e "processed_at"
        TicketDetail::create([
            'ticket_id' => $ticket->id,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ticket criado com sucesso.');
    }
}

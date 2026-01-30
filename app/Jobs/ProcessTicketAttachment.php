<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Notifications\TicketAttachmentProcessed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ProcessTicketAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Ticket $ticket;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket)
    {
        
        $this->ticket = $ticket;
    }

    public function handle(): void
    {
        if (!$this->ticket->attachment_path) {
            return;
        }

        if (!Storage::exists($this->ticket->attachment_path)) {
            return;
        }

        $content = Storage::get($this->ticket->attachment_path);

        $details = $content;

        $decoded = json_decode($content, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $details = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $detail = $this->ticket->detail ?? new TicketDetail([
            'ticket_id' => $this->ticket->id,
        ]);

        $detail->details = $details;
        $detail->processed_at = Carbon::now();
        $detail->save();

        $responsavel = $this->ticket->assignedTo ?? $this->ticket->createdBy;

        if ($responsavel) {
            $responsavel->notify(new TicketAttachmentProcessed($this->ticket));
        }
    }
}

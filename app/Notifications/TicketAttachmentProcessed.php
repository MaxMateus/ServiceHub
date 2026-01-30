<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketAttachmentProcessed extends Notification implements ShouldQueue
{
    use Queueable;

    public Ticket $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ticket processado: ' . $this->ticket->title)
            ->greeting('Olá ' . $notifiable->name . '!')
            ->line('O anexo do ticket #' . $this->ticket->id . ' foi processado.')
            ->line('Título: ' . $this->ticket->title)
            ->line('Projeto: ' . $this->ticket->project->name)
            ->line('Company: ' . $this->ticket->project->company->name)
            ->line('Os detalhes técnicos foram atualizados e estão disponíveis no TicketDetail.')
            ->line('Esta é uma mensagem automática do ServiceHub.');
    }
}

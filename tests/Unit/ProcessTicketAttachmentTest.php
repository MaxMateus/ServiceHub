<?php

namespace Tests\Unit;

use App\Jobs\ProcessTicketAttachment;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\User;
use App\Notifications\TicketAttachmentProcessed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ProcessTicketAttachmentTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;


    public function test_job_processes_attachment_updates_detail_and_notifies_responsible(): void
    {
        Notification::fake();
        Storage::fake(); // usa o disco local fake

        $responsavel = User::factory()->create();
        $project     = Project::factory()->create();

        // cria um arquivo JSON fake
        $content = json_encode([
            'prioridade' => 'alta',
            'ambiente'   => 'produção',
        ]);

        $path = 'attachments/test-job.json';
        Storage::put($path, $content);

        /** @var Ticket $ticket */
        $ticket = Ticket::factory()->create([
            'project_id'      => $project->id,
            'assigned_to'     => $responsavel->id,
            'attachment_path' => $path,
        ]);

        // cria o TicketDetail vazio como no fluxo normal
        TicketDetail::create([
            'ticket_id' => $ticket->id,
        ]);

        // congela o tempo
        Carbon::setTestNow(now());

        // executa o Job
        $job = new ProcessTicketAttachment($ticket->fresh());
        $job->handle();

        $ticket->refresh();
        $detail = $ticket->detail;

        $this->assertNotNull($detail);
        $this->assertStringContainsString('"prioridade": "alta"', $detail->details);
        $this->assertNotNull($detail->processed_at);
        $this->assertEquals(
            now()->toDateTimeString(),
            $detail->processed_at->toDateTimeString()
        );

        // notificação enviada para o responsável
        Notification::assertSentTo(
            $responsavel,
            TicketAttachmentProcessed::class
        );

        Carbon::setTestNow(); // limpa o fake now
    }
}

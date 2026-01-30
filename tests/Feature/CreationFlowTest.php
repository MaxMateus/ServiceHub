<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class CreationFlowTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;


    public function test_creates_company_via_post(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('companies.store'), [
            'name' => 'Empresa Teste',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('companies', [
            'name' => 'Empresa Teste',
        ]);
    }

    public function test_creates_project_linked_to_company(): void
    {
        $user    = User::factory()->create();
        $company = Company::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('projects.store'), [
            'company_id' => $company->id,
            'name'       => 'Projeto Teste',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('projects', [
            'company_id' => $company->id,
            'name'       => 'Projeto Teste',
        ]);
    }

    public function test_creates_ticket_and_ticket_detail(): void
    {
        $creator   = User::factory()->create();
        $assignee  = User::factory()->create();
        $project   = Project::factory()->create();

        $this->actingAs($creator);

        $response = $this->post(route('tickets.store'), [
            'project_id'  => $project->id,
            'title'       => 'Ticket Teste',
            'description' => 'Descrição do ticket teste',
            'assigned_to' => $assignee->id,
        ]);

        $response->assertRedirect(route('dashboard'));

        /** @var Ticket $ticket */
        $ticket = Ticket::query()->latest('id')->first();

        $this->assertNotNull($ticket);
        $this->assertEquals('Ticket Teste', $ticket->title);
        $this->assertNotNull($ticket->detail); // TicketDetail criado junto
    }
}

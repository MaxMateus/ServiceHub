<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;


    public function test_company_has_many_projects(): void
    {
        $company  = Company::factory()->create();
        $projects = Project::factory()->count(3)->create([
            'company_id' => $company->id,
        ]);

        $this->assertCount(3, $company->projects);
        $this->assertEqualsCanonicalizing(
            $projects->pluck('id')->all(),
            $company->projects->pluck('id')->all()
        );
    }

    public function test_project_has_many_tickets(): void
    {
        $project = Project::factory()->create();
        $tickets = Ticket::factory()->count(2)->create([
            'project_id' => $project->id,
        ]);

        $this->assertCount(2, $project->tickets);
        $this->assertEqualsCanonicalizing(
            $tickets->pluck('id')->all(),
            $project->tickets->pluck('id')->all()
        );
    }

    public function test_ticket_has_one_detail(): void
    {
        $ticket = Ticket::factory()->create();

        $detail = TicketDetail::create([
            'ticket_id' => $ticket->id,
            'details'   => 'Teste de detalhes',
        ]);

        $this->assertNotNull($ticket->detail);
        $this->assertEquals($detail->id, $ticket->detail->id);
        $this->assertEquals($ticket->id, $detail->ticket->id);
    }

    public function test_user_has_one_profile(): void
    {
        /** @var UserProfile $profile */
        $profile = UserProfile::factory()->create();

        $user = $profile->user;

        $this->assertNotNull($user->profile);
        $this->assertEquals($profile->id, $user->profile->id);
    }
}

<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id'      => Project::factory(),
            'created_by'      => User::factory(),
            'assigned_to'     => null,
            'title'           => $this->faker->sentence(4),
            'description'     => $this->faker->paragraph,
            'attachment_path' => null,
        ];
    }
}

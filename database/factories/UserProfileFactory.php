<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'phone'       => $this->faker->phoneNumber,
            'job_title'   => $this->faker->jobTitle,
            'employee_id' => (string) $this->faker->randomNumber(5),
            'department'  => $this->faker->randomElement(['TI', 'Comercial', 'Financeiro']),
        ];
    }
}

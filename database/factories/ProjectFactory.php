<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', '+2 months');
        $endDate = $this->faker->dateTimeBetween($startDate, '+18 months');

        return [
            'company_id' => Company::factory(),
            'name' => 'Project ' . implode(' ', $this->faker->words(2)),
            'code' => $this->faker->unique()->regexify('PROJ-[0-9]{4}-[0-9]{3}'),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city() . ', ' . $this->faker->countryCode(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'budget' => $this->faker->randomFloat(2, 100000, 10000000),
            'status' => $this->faker->randomElement(['planning', 'active', 'on_hold', 'completed'])
        ];
    }
}
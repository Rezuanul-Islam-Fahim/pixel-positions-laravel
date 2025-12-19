<?php

namespace Database\Factories;

use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'salary' => fake()->randomElement([
                '$60000',
                '$34000',
                '$120000',
                '$75000',
                '$90000',
                '$100000'
            ]),
            'url' => fake()->url(),
            'location' => fake()->address(),
            'schedule' => fake()->randomElement(['Full Time', 'Part Time', 'Remote']),
            'featured' => fake()->randomElement([true, false]),
            'employer_id' => Employer::factory(),
        ];
    }
}

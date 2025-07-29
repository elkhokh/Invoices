<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\sections>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
    // 'section_name' => $this->faker->unique()->words(2, true),
    // 'description'   => $this->faker->sentence(10),
    // 'created_by'    => $this->faker->name(),
];
    }
}

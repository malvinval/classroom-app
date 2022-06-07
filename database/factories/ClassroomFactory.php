<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "creator_id" => mt_rand(1, 10),
            "name" => "Matematika Diskrit",
            "slug" => $this->faker->slug(3),
            "access_code" => strtoupper($this->faker->bothify('?##??##?')),
            "description" => $this->faker->word(5)
        ];
    }
}

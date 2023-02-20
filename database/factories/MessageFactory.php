<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_by_id' => '',
            'message_parent_id' => null,
            'sending_to_id' => null,
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph()
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderHistoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 20),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(4, 1, 100),
        ];
    }

}

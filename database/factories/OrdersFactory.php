<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']),
        ];
    }

}

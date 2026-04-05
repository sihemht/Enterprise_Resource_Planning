<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'customer_id' => \App\Models\Customer::factory(),
            'quantity' => fake()->numberBetween(1, 10),
            'total_amount' => 0, //Calcule dans le seeder
            'order_date' => fake()->dateTimeBetween('-2 years', 'now'),
        ];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $customers = \App\Models\Customer::factory(50)->create();
        $products = \App\Models\Product::factory(20)->create();

        // 2. Créer 1000 commandes aléatoires pour l'historique
        for ($i = 0; $i < 1000; $i++) {
            $product = $products->random();
            $qty = rand(1, 5);

            \App\Models\Order::factory()->create([
                'customer_id' => $customers->random()->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'total_amount' => $product->price * $qty,
                'order_date' => fake()->dateTimeBetween('-2 years', 'now'),
            ]);
        }

    }
}

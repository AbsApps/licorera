<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Product;
use App\Models\Invoice;

class InvoiceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => Invoice::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 10),
            'active' => $this->faker->numberBetween(0, 1),
            'created_at' => $this->faker->date(),
            'updated_at' => $this->faker->date(),
        ];
    }
} 

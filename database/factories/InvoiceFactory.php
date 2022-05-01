<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;
use App\Models\Client;

class InvoiceFactory extends Factory
{

    protected  $model = Invoice::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'client_id' => Client::inRandomOrder()->first()->id,
            // 'name' => $this->faker->company(),
            'code' => $this->faker->ein(),
            'description' => $this->faker->sentence(),
            // 'email' => $this->faker->unique()->safeEmail(),
            'active' => $this->faker->numberBetween(0, 1),
            'created_at' => $this->faker->date(),
            'updated_at' => $this->faker->date(),
        ];
    }
}

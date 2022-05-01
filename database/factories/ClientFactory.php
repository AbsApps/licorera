<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;


class ClientFactory extends Factory

{

    protected  $model = Client::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'code' => $this->faker->ein(),
            'ruc' => $this->faker->ein(),
            'email' => $this->faker->unique()->safeEmail(),
            'active' => $this->faker->numberBetween(0, 1),
            'created_at' => $this->faker->date(),
            'updated_at' => $this->faker->date(),
        ];
    }
}

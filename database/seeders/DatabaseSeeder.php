<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            ExchangeRateSeeder::class,
            ClientSeeder::class,
            ProductSeeder::class,
            InvoiceSeeder::class,
            InvoiceDetailSeeder::class

        ]);
    }
}

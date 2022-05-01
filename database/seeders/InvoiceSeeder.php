<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invoice::factory(10)->create();
    }
}

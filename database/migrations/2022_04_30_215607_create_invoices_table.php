<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id') // UNSIGNED BIG INT
                ->references('id')
                ->on('clients');
            $table->foreignId('exchange_rate_id') // UNSIGNED BIG INT
                ->references('id')
                ->on('exchange_rates');
            $table->string('code')->unique();
            $table->string('description');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('invoices');
    }
}

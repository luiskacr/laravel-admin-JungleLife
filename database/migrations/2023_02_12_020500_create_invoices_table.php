<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('client')->references('id')->on('customers');
            $table->date('date');
            $table->integer('total');
            $table->foreignId('state')->references('id')->on('invoice_states');
            $table->foreignId('type')->references('id')->on('payment_types');
            $table->foreignId('money')->references('id')->on('payment_types');
            $table->foreignId('exchange')->references('id')->on('exchange_rates');
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
        Schema::dropIfExists('invoices');
    }
};

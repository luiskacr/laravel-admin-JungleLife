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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice')->references('id')->on('invoices');
            $table->foreignId('tour')->nullable()->references('id')->on('tours');
            $table->foreignId('product')->references('id')->on('products');
            $table->decimal('price');
            $table->integer('quantity');
            $table->decimal('total');
            $table->foreignId('money')->references('id')->on('money_types');
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
        Schema::dropIfExists('invoice_details');
    }
};

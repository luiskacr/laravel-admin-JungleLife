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
        Schema::create('tour_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour')->references('id')->on('tours');
            $table->foreignId('client')->references('id')->on('customers');
            $table->foreignId('guides')->nullable()->references('id')->on('guides');
            $table->integer('bookings');
            $table->integer('royalties');
            $table->boolean('present');
            //$table->foreignId('invoice')->nullable(true)->references('id')->on('invoices');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_clients');
    }
};

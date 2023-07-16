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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title',100)->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('info',500)->nullable();
            $table->foreignId('state')->references('id')->on('tour_states');
            $table->foreignId('type')->references('id')->on('tour_types');
            $table->foreignId('user')->references('id')->on('users');
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
        Schema::dropIfExists('tours');
    }
};

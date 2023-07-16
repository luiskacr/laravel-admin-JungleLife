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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('old');
            $table->integer('new');
            $table->foreignId('user')->references('id')->on('users');
            $table->foreignId('reviewer')->nullable()->references('id')->on('users');
            $table->foreignId('tour')->references('id')->on('tours');
            $table->foreignId('state')->references('id')->on('approval_options');
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
        Schema::dropIfExists('approvals');
    }
};

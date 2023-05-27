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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // $table->string('item_id');
            $table->foreignId('item_id')->references('id')->on('items');
            // $table->string('room_id');
            $table->foreignId('room_id')->references('id')->on('rooms');
            $table->foreignId('building_id')->references('id')->on('buildings');
            // $table->string('user_id');
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->foreignId('status')->references('id')->on('statuses');
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
        Schema::dropIfExists('transactions');
    }
};

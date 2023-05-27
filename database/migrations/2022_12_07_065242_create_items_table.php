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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            // $table->string('category_id');
            $table->string('item_id')->nullable(true);
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('title');
            $table->text('description');
            $table->float('price');
            $table->foreignId('status')->references('id')->on('statuses');
            $table->foreignId('sponsored')->references('id')->on('sponsors'); 
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
        Schema::dropIfExists('items');
    }
};

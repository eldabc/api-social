<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('delivery_address');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->bigInteger('total_order');
            $table->bigInteger('status_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            
            $table->foreign('status_id')->references('id')->on('status_orders');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('orders');
    }
}

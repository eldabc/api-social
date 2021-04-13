<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResaleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resale_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inventory');
            $table->bigInteger('shipping_value');
            $table->bigInteger('delivery_time');
            $table->integer('status');
            $table->bigInteger('unitary_price');

            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products');
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
        //
    }
}

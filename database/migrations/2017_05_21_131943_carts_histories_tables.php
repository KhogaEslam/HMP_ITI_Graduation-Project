<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartsHistoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("product_id")->unsigned();
            $table->integer("user_id")->unsigned();
            $table->double("price");
            $table->integer("quantity");

            $table->foreign("user_id")
                ->on("users")
                ->references("id")
                ->onDelete("cascade");

            $table->foreign("product_id")
                ->on("products")
                ->references("id")
                ->onDelete("cascade");


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
        Schema::dropIfExists('carts_histories');
    }
}

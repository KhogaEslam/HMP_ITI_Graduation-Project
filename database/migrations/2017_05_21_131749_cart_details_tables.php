<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartDetailsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("cart_id")->unsigned();
            $table->integer("product_id")->unsigned();
            $table->integer("quantity")->unsigned();

            $table->foreign("cart_id")
                ->on("shopping_carts")
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
        Schema::dropIfExists('carts_details');
    }
}

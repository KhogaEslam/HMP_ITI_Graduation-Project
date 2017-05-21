<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductRatesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("rate")->unsigned();
            $table->integer("product_id")->unsigned();
            $table->integer("user_id")->unsigned();
            $table->foreign("product_id")
                ->on("products")
                ->references("id")
                ->onDelete("cascade");

            $table->foreign("user_id")
                ->on("users")
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
        Schema::dropIfExists('product_rates');
    }
}

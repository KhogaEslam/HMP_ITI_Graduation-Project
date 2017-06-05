<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorIdColumnToCartHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_histories', function (Blueprint $table) {
            $table->integer("shop_id")->unsigned();

            $table->foreign("shop_id")
                ->on("users")
                ->references("id")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_histories', function (Blueprint $table) {
            //
        });
    }
}

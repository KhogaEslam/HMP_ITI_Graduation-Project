<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->date("date_of_birth");
            $table->enum('gender', ["male", "female"]);
            $table->enum("status", ["active", "suspended", "blocked"]);


            /**
             * Foreign keys
             */

            $table->integer("user_id")->unsigned(); // foreign key on user_details table


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
        Schema::dropIfExists('user_details');
    }
}

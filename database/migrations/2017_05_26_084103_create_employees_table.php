<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("employee_id")->unsigned();
            $table->integer("manager_id")->unsigned();
            $table->foreign('employee_id')
                ->on("users")
                ->references("id")
                ->onDelete("cascade");

            $table->foreign('manager_id')
                ->on("users")
                ->references("id")
                ->onDelete("cascade");
            $table->unique(["employee_id", "manager_id"]);
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
        Schema::dropIfExists('employees');
    }
}

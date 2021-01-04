<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('employee_dob');
            $table->string('employee_first_name', 100);
            $table->string('employee_last_name', 100)->nullable();
            $table->enum('employee_gender', ['M', 'F'])->default('M'); //M for Male F for Female
            $table->date('employee_hire_date');
            $table->timestamps();
            $table->softDeletes();
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

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
        Schema::create('vactinations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('dose');
            $table->date('date');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('vaccine_id')->unsigned();
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vactinations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentsTables extends Migration
{

  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('students', function (Blueprint $table) {

      $table->increments('id');
      $table->string('name')->nullable();
      $table->string('content')->nullable();

      $table->timestamps();
      //$table->softDeletes();

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down()
  {
    Schema::dropIfExists('students');
  }
}
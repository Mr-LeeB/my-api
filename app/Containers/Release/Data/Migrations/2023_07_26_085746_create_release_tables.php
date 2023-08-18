<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReleaseTables extends Migration
{

  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('releases', function (Blueprint $table) {

      $table->increments('id');

      $table->string('name', 255)->unique()->nullable();
      $table->date('date_created')->nullable();
      $table->string('title_description', 255)->nullable();
      $table->text('detail_description')->nullable();
      $table->boolean('is_publish')->default(false);
      $table->jsonb('images')->nullable();

      $table->timestamps();
      //$table->softDeletes();

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down()
  {
    Schema::dropIfExists('releases');
  }
}
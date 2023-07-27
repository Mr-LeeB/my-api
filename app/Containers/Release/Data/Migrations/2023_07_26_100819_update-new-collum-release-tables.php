<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateNewCollumReleaseTables extends Migration
{

  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::table('releases', function (Blueprint $table) {

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
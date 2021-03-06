<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('follows', function (Blueprint $table) {
      $table->bigInteger('teacher_id');
      $table->bigInteger('classroom_id');
      $table->integer('hours')->nullable();
      $table->string('day', 100)->nullable();
      $table->bigInteger('created_user');
      $table->bigInteger('updated_user');
      $table->bigInteger('deleted_user')->nullable();
      $table->softDeletes();
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
    Schema::dropIfExists('follows');
  }
}

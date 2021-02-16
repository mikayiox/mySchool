<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notifications', function (Blueprint $table) {
      $table->id();
      $table->integer('title')->nullable();
      $table->string('message', 256)->nullable();
      $table->bigInteger('kins_id');
      $table->boolean('is_payreminder');
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
    Schema::dropIfExists('notifications');
  }
}

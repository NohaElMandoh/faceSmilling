<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCaptureImgsTable extends Migration {

	public function up()
	{
		Schema::create('capture_imgs', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('path', 100)->nullable();
			$table->string('face_status_id')->nullable();
			$table->integer('users_id')->unsigned();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('capture_imgs');
	}
}
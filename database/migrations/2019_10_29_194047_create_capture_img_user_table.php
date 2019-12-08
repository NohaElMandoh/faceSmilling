<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCaptureImgUserTable extends Migration {

	public function up()
	{
		Schema::create('capture_img_user', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('capture_img_id');
			$table->integer('user_id')->unsigned();
			$table->integer('status');
			$table->string('path', 200);
			$table->string('matching', 191);
			$table->string('ellapsed_time', 50);
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('capture_img_user');
	}
}
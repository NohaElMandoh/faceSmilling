<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateColorfulImgUserTable extends Migration {

	public function up()
	{
		Schema::create('colorful_img_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('colorful_imgs_id')->nullable();
			$table->integer('status')->nullable();
			$table->integer('user_id');
			$table->string('selected_color');
			$table->softDeletes();
			$table->timestamps();

		
		});
	}

	public function down()
	{
		Schema::drop('colorful_img_user');
	}
}
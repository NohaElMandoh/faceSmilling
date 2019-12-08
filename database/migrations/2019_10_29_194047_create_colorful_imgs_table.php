<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateColorfulImgsTable extends Migration {

	public function up()
	{
		Schema::create('colorful_imgs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('photo', 200)->nullable();
			$table->integer('user_id')->unsigned();
			$table->string('color');

			$table->softDeletes();
			$table->timestamps();

		});
	}

	public function down()
	{
		Schema::drop('colorful_imgs');
	}
}
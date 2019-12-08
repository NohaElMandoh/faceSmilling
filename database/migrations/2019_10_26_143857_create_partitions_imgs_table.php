<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartitionsImgsTable extends Migration {

	public function up()
	{
		Schema::create('partitions_imgs', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('face_partitions_id')->nullable();
			$table->string('ques', 150)->nullable();
			$table->string('path', 200)->nullable();
			$table->integer('user_id')->unsigned();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('partitions_imgs');
	}
}
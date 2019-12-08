<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartitionImgUserTable extends Migration {

	public function up()
	{
		Schema::create('partition_img_user', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('partition_img_id')->nullable();
			$table->integer('status')->nullable();
			
			$table->integer('user_id');
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('partition_img_user');
	}
}
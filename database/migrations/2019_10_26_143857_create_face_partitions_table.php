<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacePartitionsTable extends Migration {

	public function up()
	{
		Schema::create('face_partitions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 50)->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('face_partitions');
	}
}
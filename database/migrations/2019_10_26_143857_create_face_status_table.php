<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaceStatusTable extends Migration {

	public function up()
	{
		Schema::create('face_status', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('status', 50)->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('face_status');
	}
}
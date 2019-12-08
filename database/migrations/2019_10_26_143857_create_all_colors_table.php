<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllColorsTable extends Migration {

	public function up()
	{
		Schema::create('all_colors', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 50)->nullable();
			$table->string('hex', 100)->nullable();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('all_colors');
	}
}
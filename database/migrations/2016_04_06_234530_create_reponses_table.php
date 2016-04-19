<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReponsesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reponses', function(Blueprint $table)
		{
			$table->integer('id',true);
			$table->string('reponse')->nullable();
			$table->char('is_true', 1)->default('f');
			$table->integer('Question_id')->index('Ques_rep');
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reponses');
	}

}

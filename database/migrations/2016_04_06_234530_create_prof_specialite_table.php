<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfSpecialiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prof_specialite', function(Blueprint $table)
		{
			$table->string('id_prof', 10);
			$table->integer('id_specialite')->index('id_specialite');
			$table->primary(['id_prof','id_specialite']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prof_specialite');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prof', function(Blueprint $table)
		{
			$table->string('CIN', 10)->primary();
			$table->string('Nom', 50);
			$table->string('Prenom', 50);
			$table->string('Adresse');
			$table->string('avatar')->nullable();
			$table->integer('compte')->index('User');
			$table->enum('active',array('y','n'))->default('n');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prof');
	}

}

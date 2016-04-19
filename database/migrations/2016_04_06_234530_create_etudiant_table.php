<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEtudiantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('etudiant', function(Blueprint $table)
		{
			$table->string('CIN', 10)->primary();
			$table->string('Nom', 50);
			$table->string('Prenom', 50);
			$table->string('Adresse');
			$table->string('avatar')->nullable();
			$table->integer('compte_id')->index('User');
			$table->integer('id_specialite')->index('user_speciality_idx');
			$table->enum('active',array('y','n'))->default('n');
			$table->enum("blocked",array('y','n'))->default('n');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('etudiant');
	}

}

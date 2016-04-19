<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEtudiantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('etudiant', function(Blueprint $table)
		{
			$table->foreign('compte_id', 'etudiant_foreignKey_Compte')->references('id')->on('comptes')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('id_specialite', 'etudiant_foreignKey_Specialite')->references('id')->on('specialite')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('etudiant', function(Blueprint $table)
		{
			$table->dropForeign('etudiant_foreignKey_Compte');
			$table->dropForeign('etudiant_foreignKey_Specialite');
		});
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prof', function(Blueprint $table)
		{
			$table->foreign('compte', 'prof_foreignKey_Compt')->references('id')->on('comptes')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('prof', function(Blueprint $table)
		{
			$table->dropForeign('prof_foreignKey_Compt');
		});
	}

}

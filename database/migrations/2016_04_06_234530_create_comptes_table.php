<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComptesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comptes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('email', 100);
			$table->string('user', 40);
			$table->string('password', 100);
			$table->string('phone', 15);
			$table->enum('role', array('admin','prof','etudiant'));
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
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
		Schema::drop('comptes');
	}

}

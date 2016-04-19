<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exams', function(Blueprint $table)
		{
			$table->integer('id',true);
			$table->dateTime('date');
			$table->string('description')->nullable();
			$table->enum('type', array('Blanche','officiel'))->nullable();
			$table->integer('Pile')->index('pile_exam');
			$table->string('etudiant', 10)->index('exame_etudiant_idx');
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
		Schema::drop('exams');
	}

}

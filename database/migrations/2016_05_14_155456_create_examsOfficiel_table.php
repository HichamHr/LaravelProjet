<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsOfficielTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examsOfficiel', function(Blueprint $table)
        {
            $table->integer('id_exam',true);
            $table->integer('id_pile')->index('pile');
            $table->date('date_exam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('examsOfficiel');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblGravidanzeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_gravidanze', function (Blueprint $table) {

            $table->increments('id_gravidanza');
            $table->integer('id_paziente');
            $table->text('esito')->nullable();
            $table->text('eta')->nullable();
            $table->date('inizio_gravidanza')->nullable();
            $table->date('fine_gravidanza')->nullable();
            $table->text('sesso_bambino')->nullable();
            $table->text('note_gravidanza')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_gravidanze');
    }
}

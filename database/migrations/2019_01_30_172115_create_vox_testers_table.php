<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoxTestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vox_testers', function (Blueprint $table) {
            $table->increments('id_voxtester');
            $table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx')->onDelete('cascade');
            $table->text('date')->nullable();
            $table->text('audio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vox_testers');
    }
}

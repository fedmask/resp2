<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitaSpecializationTable extends Migration
{
    
    public $set_schema_table = 'tbl_visita_specialization';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->increments('id_vs');
            $table->integer('id_visita')->unsigned();
            $table->integer('id_specialization')->unsigned();
            
            $table->foreign('id_visita', 'FOREIGN_Visita_Specialization_idx')
            ->references('id_visita')->on('tbl_pazienti_visite')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('id_specialization', 'FOREIGN_Specialization_idx')
            ->references('id_spec')->on('tbl_specialization')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->set_schema_table);
    }
}

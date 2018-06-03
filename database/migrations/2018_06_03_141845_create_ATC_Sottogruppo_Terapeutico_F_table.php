<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATCSottogruppoTerapeuticoFTable extends Migration
{
    
    public $set_schema_table = 'ATC_Sottogruppo_Terapeutico_F';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->char('id_sottogruppoTF',4)->primary();
            $table->char('Codice_Gruppo_Teraputico',1);
            $table->timestamps();
            $table->string('Descrizione',45);
            $table->char('ID_Gruppo_Terapeutico',3)->nullable(false);
            
            
            $table->foreign('ID_Gruppo_Terapeutico', 'FOREIGN_SottogruppoT_GruppoT_idx')
            ->references('Codice_Gruppo_Teraputico')->on('ATC_Gruppo_Terapeutico_P')
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

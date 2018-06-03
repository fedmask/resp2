<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATCGruppoTerapeuticoPTable extends Migration
{
	
	public $set_schema_table = 'ATC_Gruppo_Terapeutico_P';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->char('Codice_Gruppo_Teraputico',3)->primary();
            $table->char('Codice_GTP',2);
            $table->timestamps();
            $table->string('Descrizione',45);
            $table->char('ID_Gruppo_Anatomico',1)->nullable(false);
            
            $table->foreign('ID_Gruppo_Anatomico', 'FOREIGN_GruppoT_GruppoA_idx')
            ->references('ID_Gruppo_Anatomico')->on('tbl_Gruppo_Anatomico_P')
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

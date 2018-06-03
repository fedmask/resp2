<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblATCGruppoAnatomicoPrincipaleTable extends Migration
{
    
    public $set_schema_table = 'tbl_ATC_gruppo_anatomico_principale';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable ( $this->set_schema_table ))
            return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->char('codice_gap',1)->nullable(false);
            $table->string('descrizione',45);
            $table->primary('codice_gap');
            
            
            
            
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

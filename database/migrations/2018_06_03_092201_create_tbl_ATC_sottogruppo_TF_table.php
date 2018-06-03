<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblATCSottogruppoTFTable extends Migration
{
    
    public $set_schema_table = 'tbl_ATC_sottogruppo_tf';
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
            $table->char('codice_stf', 4)->nullable(false);
            $table->char('codice_gtp', 3)->nullable(false);
            $table->char('sottogruppo', 1)->nullable(false);
            $table->string('descrizione',45)->nullable(false);
            $table->primary(['codice_stf', 'codice_gtp']);
            
            
          
            
            $table->foreign('codice_gtp', 'fk_tbl_sottogruppo_tf_gruppo_terapeutico_idx')
            ->references('codice_gtp')->on('tbl_ATC_gruppo_terapeutico_prin');
            
          
           
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

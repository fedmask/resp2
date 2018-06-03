<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATCSottogruppoChimicoTFTable extends Migration
{
    
    public $set_schema_table = 'ATC_Sottogruppo_Chimico_TF';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->char('id_sottogruppoCTF',5)->primary();
            $table->char('Codice_Sottogruppo_Teraputico',1);
            $table->timestamps();
            $table->string('Descrizione',45);
            $table->char('ID_Sottogruppo_Terapeutico',4)->nullable(false);
            
            $table->foreign('ID_Sottogruppo_Terapeutico', 'FOREIGN_SottogruppoCFT_SottogruppoTF_idx')
            ->references('id_sottogruppoTF')->on('ATC_Sottogruppo_Terapeutico_F')
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

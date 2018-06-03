<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATCSottogruppoChimicoTable extends Migration
{
    
    public $set_schema_table = 'ATC_Sottogruppo_Chimico';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->char('Codice_ATC',7)->primary();
            $table->char('Codice_Sottogruppo_CTF',2);
            $table->timestamps();
            $table->string('Descrizione',45);
            $table->char('ID_Sottogruppo_CTF',5)->nullable(false);
            
            $table->foreign('ID_Sottogruppo_CTF', 'FOREIGN_SottogruppoC_SottogruppoCTF_idx')
            ->references('id_sottogruppoCTF')->on('ATC_Sottogruppo_Chimico_TF')
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

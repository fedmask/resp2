<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblProcTer extends Migration
{
    public $set_schema_table = 'tbl_proc_terapeutiche';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            $table->increments('id_Procedure_Terapeutiche');
            $table->string('descrizione',45);
            $table->date('Data_Esecuzione');
            $table->integer('Paziente')->unsigned();
            $table->integer('Diagnosi')->unsigned();
            $table->integer('CareProvider')->unsigned();
            $table->string('Codice_icd9',7);
            $table->string('Status',20);
            $table->boolean('notDone');
            $table->integer('Category')->unsigned();
            // Chiedere delucidazioni sulla risorsa fhir encounter
            $table->integer('outCome')->unsigned();
            $table->text('note');
            
            
            
            //creo le chiavi esterne
            $table->foreign('Paziente', 'fk_tb_paziente_tb_procedure_treapeutiche')
            ->references('id_paziente')->on('tbl_pazienti')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('Diagnosi', 'fk_tb_diagnosi_tb_procedure_treapeutiche')
            ->references('id_diagnosi')->on('tbl_diagnosi')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('CareProvider', 'fk_tb_cpp_tb_procedure_treapeutiche')
            ->references('id_cpp')->on('tbl_care_provider')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('Codice_icd9', 'fk_tb_icd9_tb_procedure_treapeutiche')
            ->references('Codice_ICD9')->on('Tbl_ICD9_ICPT')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            
            $table->foreign('Category', 'fk_tb_proc_category')
            ->references('codice')->on('tbl_proc_cat')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('outCome', 'fk_tb_proc_outcome')
            ->references('codice')->on('tbl_proc_outcome')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('Status', 'fk_tb_proc_status')
            ->references('codice')->on('tbl_proc_status')
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

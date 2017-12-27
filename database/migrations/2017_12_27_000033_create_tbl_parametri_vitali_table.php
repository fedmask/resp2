<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblParametriVitaliTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_parametri_vitali';

    /**
     * Run the migrations.
     * @table tbl_parametri_vitali
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_parametro_vitale');
            $table->integer('id_paziente')->unsigned();
            $table->integer('id_audit_log')->unsigned();
            $table->smallInteger('parametro_altezza');
            $table->smallInteger('parametro_peso');
            $table->smallInteger('parametro_pressione_minima');
            $table->smallInteger('parametro_pressione_massima');
            $table->smallInteger('parametro_frequenza_cardiaca');
            $table->tinyInteger('parametro_dolore');

            $table->index(["id_audit_log"], 'fk_tbl_parametri_vitali_tbl_auditlog_log1_idx');

            $table->index(["id_paziente"], 'fk_tbl_parametri_vitali_tbl_pazienti1_idx');


            $table->foreign('id_paziente', 'fk_tbl_parametri_vitali_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_audit_log', 'fk_tbl_parametri_vitali_tbl_auditlog_log1_idx')
                ->references('id_audit')->on('tbl_auditlog_log')
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

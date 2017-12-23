<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblOperazioniLogTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_operazioni_log';

    /**
     * Run the migrations.
     * @table tbl_operazioni_log
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_operazione');
            $table->integer('id_audit_log');
            $table->char('operazione_codice', 2);
            $table->time('operazione_orario');

            $table->index(["operazione_codice"], 'fk_tbl_operazioni_log_tbl_codici_operazioni1_idx');

            $table->index(["id_audit_log"], 'fk_tbl_operazioni_log_tbl_auditlog_log1_idx');


            $table->foreign('operazione_codice', 'fk_tbl_operazioni_log_tbl_codici_operazioni1_idx')
                ->references('id_codice')->on('tbl_codici_operazioni')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_audit_log', 'fk_tbl_operazioni_log_tbl_auditlog_log1_idx')
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

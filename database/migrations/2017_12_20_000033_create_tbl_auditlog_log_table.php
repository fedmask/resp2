<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAuditlogLogTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_auditlog_log';

    /**
     * Run the migrations.
     * @table tbl_auditlog_log
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_audit');
            $table->string('audit_nome', 100);
            $table->string('audit_ip', 39);
            $table->integer('id_visitato');
            $table->integer('id_visitante');
            $table->date('audit_data');

            $table->index(["id_visitato"], 'fk_tbl_auditlog_log_tbl_utenti2_idx');

            $table->index(["id_visitante"], 'fk_tbl_auditlog_log_tbl_utenti1_idx');


            $table->foreign('id_visitante', 'fk_tbl_auditlog_log_tbl_utenti1_idx')
                ->references('id_utente')->on('tbl_utenti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_visitato', 'fk_tbl_auditlog_log_tbl_utenti2_idx')
                ->references('id_utente')->on('tbl_utenti')
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

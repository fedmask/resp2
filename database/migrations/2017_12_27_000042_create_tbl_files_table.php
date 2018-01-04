<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFilesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_files';

    /**
     * Run the migrations.
     * @table tbl_files
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_file');
            $table->integer('id_paziente')->unsigned();
            $table->integer('id_audit_log')->unsigned();
            $table->smallInteger('id_file_confidenzialita');
            $table->string('file_nome', 60);
            $table->text('file_commento');
            $table->date('updated_at');
            $table->date('created_at');

            $table->index(["id_paziente"], 'fk_tbl_files_tbl_pazienti1_idx');

            $table->index(["id_file_confidenzialita"], 'fk_tbl_files_tbl_livelli_confidenzialita1_idx');

            $table->index(["id_audit_log"], 'fk_tbl_files_tbl_auditlog_log1_idx');


            $table->foreign('id_paziente', 'fk_tbl_files_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_file_confidenzialita', 'fk_tbl_files_tbl_livelli_confidenzialita1_idx')
                ->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_audit_log', 'fk_tbl_files_tbl_auditlog_log1_idx')
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEffettiCollateraliTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_effetti_collaterali';

    /**
     * Run the migrations.
     * @table tbl_effetti_collaterali
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_effetto_collaterale');
            $table->integer('id_paziente');
            $table->integer('id_audit_log');
            $table->text('effetto_collaterale_descrizione');

            $table->index(["id_audit_log"], 'fk_tbl_effetti_collaterali_tbl_auditlog_log1_idx');

            $table->index(["id_paziente"], 'fk_tbl_effetti_collaterali_tbl_pazienti1_idx');


            $table->foreign('id_audit_log', 'fk_tbl_effetti_collaterali_tbl_auditlog_log1_idx')
                ->references('id_audit')->on('tbl_auditlog_log')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_paziente', 'fk_tbl_effetti_collaterali_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
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

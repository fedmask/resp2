<?php

use Illuminate\Database\Seeder;

class AuditLogTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_auditlog_log')->insert([
            ["id_audit" => 2, 'audit_nome' => "Test", 'audit_ip' => "192.168.1.1", "id_visitato" => 1, "id_visitante" => 1, "audit_data" => "2018-03-14" ]
        ]);
    }
}

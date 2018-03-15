<?php

use Illuminate\Database\Seeder;

class ParametriVitaliTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_auditlog_log')->insert([
            
            'audit_nome'=>'Jan',
            'audit_ip'=>'ip',
            'id_visitato'=>'2',
            'id_visitante'=>'2',
            'audit_data'=>'2018-02-03'
        ]);
        
        
        DB::table('tbl_parametri_vitali')->insert([
            'id_paziente'=>'2',
            'id_audit_log'=> '1',
            'parametro_altezza'=>'180',
            'parametro_peso'=>'85',
            'parametro_pressione_minima'=>'75',
            'parametro_pressione_massima'=>'129',
            'parametro_frequenza_cardiaca'=>'60'
        ]);
        
        DB::table('tbl_parametri_vitali')->insert([
            'id_paziente'=>'2',
            'id_audit_log'=> '1',
            'parametro_altezza'=>'',
            'parametro_peso'=>'',
            'parametro_pressione_minima'=>'70',
            'parametro_pressione_massima'=>'120',
            'parametro_frequenza_cardiaca'=>'80'
        ]);
    }
}

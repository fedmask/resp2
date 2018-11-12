<?php
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisiteTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_pazienti_visite')->insert([
            'id_visita' => '1',
            'id_cpp' => '1',
            'id_paziente' => '2',
            'status' => 'planned',
            'class' => 'AMB',
            'start_period' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'end_period' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'reason' => '109006',
            'visita_data' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'visita_motivazione' => 'Motivazione 1',
            'visita_osservazioni' => 'Osservazioni 1',
            'visita_conclusioni' => 'Conclusioni 1',
            'stato_visita' => 'booked',
            'codice_priorita' => '1',
            'tipo_richiesta' => 'required',
            'richiesta_visita_inizio' => '2016-06-02',
            'richiesta_visita_fine' => '2016-06-02'
        ]);
        
        DB::table('tbl_pazienti_visite')->insert([
            'id_visita' => '2',
            'id_cpp' => '1',
            'id_paziente' => '2',
            'status' => 'arrived',
            'class' => 'EMER',
            'start_period' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'end_period' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'reason' => '134006',
            'visita_data' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'visita_motivazione' => 'Motivazione 2',
            'visita_osservazioni' => 'Osservazioni 2',
            'visita_conclusioni' => 'Conclusioni 2',
            'stato_visita' => 'arrived',
            'codice_priorita' => '2',
            'tipo_richiesta' => 'optional',
            'richiesta_visita_inizio' => null,
            'richiesta_visita_fine' => null
        ]);
    }
}

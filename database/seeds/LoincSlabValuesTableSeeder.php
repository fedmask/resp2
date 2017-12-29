<?php

use Illuminate\Database\Seeder;

class LoincSlabValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('tbl_loinc_valori')->insert([
      ['id_esclab' => '1','id_codice' => '1751-7','valore_normale' => '3.5-5.5 g/dL 
'],
      ['id_esclab' => '2','id_codice' => '17861-6','valore_normale' => '8.9-10.1 mg/dL 
'],
      ['id_esclab' => '3','id_codice' => '2160-0','valore_normale' => '8.7-1.2 mg/dL 
'],
      ['id_esclab' => '4','id_codice' => '24325-3','valore_normale' => '45-115 U/L 
'],
      ['id_esclab' => '5','id_codice' => '2075-0','valore_normale' => '96-106 mmol/L 
'],
      ['id_esclab' => '6','id_codice' => '2823-3','valore_normale' => '3.6-5.2 mmol/L 
'],
      ['id_esclab' => '7','id_codice' => '2951-2 ','valore_normale' => '135-145 mmol/L 
'],
      ['id_esclab' => '8','id_codice' => '32698-3','valore_normale' => '1.7-2.2 mg/dL 
'],
      ['id_esclab' => '9','id_codice' => '2774-8','valore_normale' => '2.6-4.5 mg/dL 
'],
      ['id_esclab' => '10','id_codice' => '27353-2','valore_normale' => '70-99 g/dl 
'],
      ['id_esclab' => '11','id_codice' => '27975-2','valore_normale' => '0.3-5 mlU/L 
'],
      ['id_esclab' => '12','id_codice' => '3026-2','valore_normale' => '5.0-12.5 mcg/dL 
'],
      ['id_esclab' => '13','id_codice' => '3053-6','valore_normale' => '80-190 ng/dL 
'],
      ['id_esclab' => '14','id_codice' => '30341-2','valore_normale' => '17-25 mm/hr 
'],
      ['id_esclab' => '15','id_codice' => '30934-4','valore_normale' => '<100 pg/ml 
'],
      ['id_esclab' => '16','id_codice' => '3094-0','valore_normale' => '7-23 mg/dL 
'],
      ['id_esclab' => '17','id_codice' => '3094-0','valore_normale' => 'da eseguire 
'],
    ]);
    }
}

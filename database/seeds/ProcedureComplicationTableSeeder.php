<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ProcedureComplication;

class ProcedureComplicationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ProcedureComplication.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ProcedureComplication::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

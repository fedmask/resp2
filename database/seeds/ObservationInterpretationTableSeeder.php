<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ObservationInterpretation;

class ObservationInterpretationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ObservationInterpretation.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ObservationInterpretation::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}

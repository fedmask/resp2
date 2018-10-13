<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\EncounterClass;

class EncounterClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/EncounterClass.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            EncounterClass::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}

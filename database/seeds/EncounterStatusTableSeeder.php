<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\EncounterStatus;

class EncounterStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/EncounterStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            EncounterStatus::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}

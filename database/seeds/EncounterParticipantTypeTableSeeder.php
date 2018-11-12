<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\EncounterParticipantType;

class EncounterParticipantTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/EncounterParticipantType.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            EncounterParticipantType::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}

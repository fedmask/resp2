<?php
use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\EncounterReason;

class EncounterReasonTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/EncounterReason.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            EncounterReason::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

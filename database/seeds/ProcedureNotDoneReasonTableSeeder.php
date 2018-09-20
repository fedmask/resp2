<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ProcedureNotDoneReason;

class ProcedureNotDoneReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ProcedureNotDoneReason.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ProcedureNotDoneReason::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

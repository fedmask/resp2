<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ProcedureFollowUp;

class ProcedureFollowUpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ProcedureFollowUp.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ProcedureFollowUp::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

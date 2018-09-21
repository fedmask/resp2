<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ProcedureBodySite;

class ProcedureBodySiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ProcedureBodySite.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ProcedureBodySite::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

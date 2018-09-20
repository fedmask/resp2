<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ConditionBodySite;

class ConditionBodySiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ConditionBodySite.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ConditionBodySite::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

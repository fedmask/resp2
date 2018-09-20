<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceReactionManifestation;

class AllergyIntolleranceReactionManifestationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceReactionManifestation.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceReactionManifestation::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

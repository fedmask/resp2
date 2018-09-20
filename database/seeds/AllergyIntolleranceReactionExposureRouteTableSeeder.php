<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceReactionExposureRoute;

class AllergyIntolleranceReactionExposureRouteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceReactionExposureRoute.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceReactionExposureRoute::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

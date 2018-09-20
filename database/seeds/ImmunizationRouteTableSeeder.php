<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ImmunizationRoute;

class ImmunizationRouteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ImmunizationRoute.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ImmunizationRoute::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

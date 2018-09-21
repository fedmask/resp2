<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ImmunizationStatus;

class ImmunizationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ImmunizationStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ImmunizationStatus::create(array(
                'code' => $obj->code
            ));
        }
    }
}

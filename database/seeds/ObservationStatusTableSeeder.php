<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ObservationStatus;

class ObservationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ObservationStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ObservationStatus::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}

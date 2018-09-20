<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\DeviceType;

class DeviceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    $json = File::get("database/data/DeviceType.json");
    $data = json_decode($json);
    foreach ($data as $obj) {
        DeviceType::create(array(
            'code' => $obj->code,
            'text' => $obj->display
        ));
    }
}
}

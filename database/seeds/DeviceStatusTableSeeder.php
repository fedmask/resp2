<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\DeviceStatus;

class DeviceStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/DeviceStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            DeviceStatus::create(array(
                'code' => $obj->code
            ));
        }
    }
}

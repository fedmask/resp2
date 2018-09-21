<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\MedicationStatus;

class MedicationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/MedicationStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            MedicationStatus::create(array(
                'code' => $obj->code
            ));
        }
    }
}

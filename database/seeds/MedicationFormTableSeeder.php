<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\MedicationForm;

class MedicationFormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/MedicationForm.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            MedicationForm::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

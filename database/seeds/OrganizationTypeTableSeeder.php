<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\OrganizationType;

class OrganizationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/OrganizationType.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            OrganizationType::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}

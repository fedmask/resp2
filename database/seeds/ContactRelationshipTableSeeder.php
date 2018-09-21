<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ContactRelationship;

class ContactRelationshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ContactRole.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ContactRelationship::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\RelationshipType;

class RelatedPersonRelationshipTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/RelatedPersonRelationshipTyper.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            RelationshipType::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}


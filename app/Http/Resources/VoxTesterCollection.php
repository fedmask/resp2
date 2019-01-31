<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VoxTesterCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id voxtester' => $this->id_voxtester,
            'id utente' => $this->id_utente,
            'Data caricamento' => $this->date,
            'Path audio' => $this->audio
        ];
    }
}

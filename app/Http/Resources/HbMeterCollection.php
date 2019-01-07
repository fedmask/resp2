<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class HbMeterCollection extends Resource
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
            'id hbmeter' => $this->id_hbmeter,
            'id utente' => $this->id_utente,
            'Analisi giorno' => $this->analisi_giorno,
            'Analisi valore' => $this->analisi_valore
        ];
    }
}
